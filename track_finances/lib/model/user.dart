class User {
  final String uid;
  String email;
  String name;

  User(this.uid, this.email);

  factory User.initialData() {
    return User('', '');
  }
}

class UserData {
  final String uid;
  String group;
  int amount;
  String monthYear;
  String createdAt;
  UserData({this.uid, this.group, this.amount, this.monthYear, this.createdAt});

  factory UserData.initialData() {
    return UserData(
        uid: '', group: '', amount: 0, monthYear: '', createdAt: '');
  }
}
