import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:track_finances/model/finance.dart';
import 'package:track_finances/widget/finance_tile.dart';

class FinanceList extends StatefulWidget {
  @override
  _FinanceListState createState() => _FinanceListState();
}

class _FinanceListState extends State<FinanceList> {
  @override
  Widget build(BuildContext context) {
    final finance = Provider.of<List<Finance>>(context);
    return ListView.builder(
        scrollDirection: Axis.vertical,
        shrinkWrap: true,
        itemCount: finance.length,
        itemBuilder: (context, index) {
          return FinanceTile(finance: finance[index]);
        });
  }
}
