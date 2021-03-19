import 'package:flutter/material.dart';
import 'package:track_finances/model/finance.dart';
import 'package:track_finances/services/database.dart';
import 'package:uuid/uuid.dart';

class FinanceProvider with ChangeNotifier {
  int _amount;
  String _financeId;
  String _group;
  String _monthYear;
  String _createdAt;
  var uuid = Uuid();
  final databaseService = DatabaseService();

  String get financeId => _financeId;
  String get group => _group;
  String get monthYear => _monthYear;
  String get createdAt => _createdAt;

  set changeAmount(int amount) {
    _amount = amount;
    notifyListeners();
  }

  set changeFinanceId(String financeId) {
    _financeId = financeId;
    notifyListeners();
  }

  set changeGroup(String group) {
    _group = group;
    notifyListeners();
  }

  set changeMonthYear(String monthYear) {
    _monthYear = monthYear;
    notifyListeners();
  }

  set changeCreateAt(String createdAt) {
    _createdAt = createdAt;
    notifyListeners();
  }

  Stream<List<Finance>> get finances => databaseService.allFinances;

  loadAll(Finance finance){
    if (finance != null){
      _amount = finance.amount;
      _group = finance.group;
      _financeId = finance.financeId;
      _monthYear = finance.monthYear;
      _createdAt = finance.createdAt;
    } else {
      _amount = finance.amount;
      _group = finance.group;
      _financeId = uuid.v4();
      _monthYear = finance.monthYear;
      _createdAt = finance.createdAt;
    }
  }

  saveFinance(){
    if (_financeId == null){
      //Add
      var newFinance = Finance(
          amount: _amount,
          group: _group,
          financeId: _financeId,
          monthYear: _monthYear,
          createdAt: _createdAt
      );
      print(newFinance.financeId);
      databaseService.setFinance(newFinance);
    } else {
      //Edit
      var updatedFinance = Finance(
      amount: _amount,
      group: _group,
      financeId: uuid.v1(),
      monthYear: _monthYear,
      createdAt: _createdAt,
    );
      databaseService.setFinance(updatedFinance);
    }
  }

  removeEntry(String finance){
    databaseService.removeEntry(financeId);
  }
}