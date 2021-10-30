import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:track_finances/model/user.dart';
import 'package:track_finances/screens/home_page.dart';
import 'package:track_finances/screens/login.dart';

class Wrapper extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final user = Provider.of<User>(context);
    if (user == null) return LoginPage();

    return HomePage();
  }
}
