import 'package:flutter/material.dart';

class Finance {
  String group;
  int amount;
  String monthYear;
  String createdAt;
  String financeId;
  Finance({ @required this.financeId, this.group, this.amount, this.monthYear, this.createdAt});

  factory Finance.fromJson(Map<String, dynamic> json) {
    return Finance(
      group: json['date'],
      amount: json['amount'],
      monthYear: json['month_year'],
      createdAt: json['created_at'],
      financeId: json['finance_id']
    );
  }

  Map<String, dynamic> toMap() {
    return {
      'group': group,
      'amount': amount,
      'month_year': monthYear,
      'created_at': createdAt,
      'finance_id': financeId
    };
  }
}