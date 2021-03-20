import 'package:flutter/material.dart';
import 'package:track_finances/model/finance.dart';
import 'package:track_finances/screens/header.dart';
import 'package:flutter_vector_icons/flutter_vector_icons.dart' as vector_icons;
import 'package:track_finances/services/auth.dart';
import 'package:provider/provider.dart';
import 'package:track_finances/services/database.dart';
import 'package:track_finances/widget/finance_list.dart';

class HomePage extends StatefulWidget {
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  final AuthService _auth = AuthService();

  @override
  Widget build(BuildContext context) {
    return StreamProvider<List<Finance>>.value(
      initialData: [],
      value: DatabaseService(group: 'development').finances,
      child: Scaffold(
        appBar: new AppBar(
          elevation: 1,
          leading: IconButton(
              icon: const Icon(Icons.short_text),
              onPressed: () {
                print("Menu button clicked");
              }),
          centerTitle: true,
          title: const Text(
            'Development Fund',
            style: TextStyle(
                fontSize: 20,
                fontFamily: 'RocknRollOne',
                fontWeight: FontWeight.w400),
          ),
          actions: <Widget>[
            IconButton(
                icon: const Icon(vector_icons.Ionicons.log_out_outline),
                onPressed: () {
                  dynamic result = _auth.logout();
                  print(result);
                })
          ],
        ),
        body: Column(
          children: [
            Header(),
            SizedBox(
              height: 10,
            ),
            FinanceList()
          ],
        ),
      ),
    );
  }
}
