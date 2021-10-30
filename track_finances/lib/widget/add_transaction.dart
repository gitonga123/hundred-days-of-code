import 'package:flutter/material.dart';
import 'package:flutter_vector_icons/flutter_vector_icons.dart' as vector_icons;
import 'package:track_finances/config/constants.dart';
import 'package:dropdown_formfield/dropdown_formfield.dart';
import 'package:track_finances/services/database.dart';

class AddTransactionForm extends StatefulWidget {
  @override
  _AddTransactionFormState createState() => _AddTransactionFormState();
}

class _AddTransactionFormState extends State<AddTransactionForm> {
  final _formKey = GlobalKey<FormState>();
  final dynamic groups = [
    {"display": 'Men Fellowship', "value": 'men'},
  ];
  String _group = '';
  int _amount;
  String _monthYear;
  DateTime selectedDate = DateTime.now();
  TextEditingController _dateController = TextEditingController();
  final DatabaseService databaseService = new DatabaseService();

  @override
  Widget build(BuildContext context) {
    return Form(
      key: _formKey,
      child: Column(
        children: [
          Text(
            "Add New Transaction",
            style: TextStyle(fontSize: MediaQuery.of(context).size.height / 30),
          ),
          SizedBox(
            height: 20.0,
          ),
          DropDownFormField(
            titleText: 'Select a Group',
            hintText: 'Please choose one',
            value: _group,
            onSaved: (value) {
              setState(() {
                _group = value;
              });
            },
            onChanged: (value) {
              setState(() {
                _group = value;
              });
            },
            dataSource: [
              {"display": 'Men Fellowship', "value": 'men'},
              {"display": 'Women Fellowship', "value": 'women'},
              {"display": 'Cell Group', 'value': 'cell'},
              {"display": "Development Fund", "value": 'development'},
              {"display": "Youth Group", "value": 'youth'},
              {"display": "Junior Church", "value": 'junior'},
            ],
            textField: 'display',
            valueField: 'value',
          ),
          TextFormField(
            keyboardType: TextInputType.number,
            validator: (value) {
              if (value.isEmpty) return 'Enter Amount';
              return null;
            },
            onChanged: (value) {
              setState(() {
                _amount = int.parse(value);
              });
            },
            decoration: InputDecoration(
                icon: Icon(vector_icons.Ionicons.cash_outline),
                labelText: 'Amount'),
          ),
          SizedBox(
            height: 10.0,
          ),
          GestureDetector(
            onDoubleTap: () => _selectDate(context),
            child: AbsorbPointer(
              child: TextFormField(
                validator: (value) {
                  if (value.isEmpty) return 'Enter Month & Year';
                  return null;
                },
                onChanged: (value) {
                  setState(() {
                    _monthYear = selectedDate.toString();
                  });
                },
                controller: _dateController,
                decoration: InputDecoration(
                    icon: Icon(vector_icons.Ionicons.calendar_outline),
                    labelText: 'Month & Year'),
              ),
            ),
          ),
          SizedBox(
            height: 20.0,
          ),
          SizedBox(
            width: 250,
            height: 50,
            child: ElevatedButton(
              onPressed: () {
                Navigator.pop(context);
                databaseService.insertUserData(
                    _group, _amount, _monthYear
                );
                SnackBar(
                    content: Text("Transaction added successfully", style: TextStyle(
                      color: Colors.white,
                      fontSize: 14,
                      fontFamily: 'Nunito',
                      fontStyle: FontStyle.italic
                    ),),
                    backgroundColor: mainColor,
                );
              },
              style: ElevatedButton.styleFrom(
                  primary: mainColor,
                  shadowColor: mainColor,
                  elevation: 2.0,
                  shape: const BeveledRectangleBorder(
                      borderRadius: BorderRadius.all(Radius.circular(5)))),
              child: Text(
                "Save Record",
                style: TextStyle(
                    color: Colors.white,
                    letterSpacing: 1.5,
                    fontSize: MediaQuery.of(context).size.height / 40),
              ),
            ),
          ),
        ],
      ),
    );
  }

  _selectDate(BuildContext context) async {
    final DateTime picked = await showDatePicker(
        context: context,
        initialDate: selectedDate,
        firstDate: DateTime(2000, 8),
        lastDate: DateTime(2100));
    if (picked != null && picked != selectedDate)
      setState(() {
        selectedDate = picked;
        var date = "${picked.toLocal().month}/${picked.toLocal().year}";
        _dateController.text = date;
        _monthYear = date.toString();
      });
  }
}
