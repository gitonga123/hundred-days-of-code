import 'package:flutter/material.dart';
import 'package:track_finances/model/finance.dart';
import 'package:flutter_vector_icons/flutter_vector_icons.dart' as vector_icons;

class FinanceTile extends StatelessWidget {
  final Finance finance;
  FinanceTile({this.finance});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: EdgeInsets.only(top: 3.0),
      child: Card(
        margin: EdgeInsets.fromLTRB(10.0, 6.0, 10.0, 0.0),
        child: ListTile(
          leading: Icon(vector_icons.Ionicons.cash),
          title: Text(finance.group),
          subtitle: Text(finance.monthYear),
          trailing: Text(finance.amount.toString()),
        ),
      ),
    );
  }
}
