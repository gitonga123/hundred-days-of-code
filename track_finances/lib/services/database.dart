import 'package:intl/intl.dart';

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:track_finances/model/finance.dart';
import 'package:track_finances/model/user.dart';
import 'package:uuid/uuid.dart';

class DatabaseService {
  final String uid;
  final String group;

  DatabaseService({this.uid, this.group});
  // collection reference
  final CollectionReference financeCollection =
      FirebaseFirestore.instance.collection('finance-collection');
  Future insertUserData(String group, int amount, String monthYear) async {
    var uuid = Uuid();
    var nowFormatted = this.currentDate();
    return financeCollection
      ..doc(uid)
          .set({
            'group': group,
            'amount': amount,
            'month_year': monthYear,
            'created_on': nowFormatted,
            'finance_id': uuid.v1()
          })
          .then((value) => print("Finance Record Added"))
          .catchError((error) => print("Failed to add record: $error"));
  }

  Future<void> setFinance(Finance finance) {
    var options = SetOptions(merge: true);
    return financeCollection
        .doc(finance.financeId)
        .set(finance.toMap(), options);
  }

  Future<void> removeEntry(String financeId) {
    return financeCollection.doc(financeId).delete();
  }

  String currentDate() {
    final DateTime now = DateTime.now();
    final DateFormat formatter = DateFormat('dd-MM-yyyy');
    final String nowFormatted = formatter.format(now);
    return nowFormatted;
  }

  List<Finance> _financeListFromSnapShot(QuerySnapshot snapshot) {
    return snapshot.docs.map((doc) {
      return Finance(
          financeId: doc.data()['finance_id'],
          group: doc.data()['group'] ?? '',
          amount: doc.data()['amount'] ?? '',
          monthYear: doc.data()['month_year'] ?? '',
          createdAt: doc.data()['created_at'] ?? '');
    }).toList();
  }

  // user data from snapshot
  UserData _userDataFromSnapShot(DocumentSnapshot snapshot) {
    return UserData(
        uid: uid,
        amount: snapshot.data()['amount'],
        group: snapshot.data()['group'],
        monthYear: snapshot.data()['monthYear'],
        createdAt: this.currentDate());
  }


  Stream<List<Finance>> get finances {
    return financeCollection
        .where('group', isEqualTo: group)
        .limit(12)
        .snapshots()
        .map(_financeListFromSnapShot);
  }

  Stream<List<Finance>> get allFinances {
    return financeCollection
        .where('group', isEqualTo: group)
        .snapshots()
        .map(_financeListFromSnapShot);
  }

  Stream<UserData> get userData {
    return financeCollection.doc(uid).snapshots().map(_userDataFromSnapShot);
  }
}
