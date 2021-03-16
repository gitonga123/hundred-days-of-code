import 'package:flutter/material.dart';
import 'package:track_finances/screens/loader.dart';
import 'dart:ui';

import 'package:track_finances/screens/login.dart';
import 'package:firebase_core/firebase_core.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(MainPage());
}

class MainPage extends StatelessWidget {
  final Future<FirebaseApp> _initialization = Firebase.initializeApp();
  static const Map<int, Color> colorMap = {
    50: Color.fromRGBO(26, 143, 255, 0.1),
    100: Color.fromRGBO(26, 143, 255, 0.2),
    200: Color.fromRGBO(26, 143, 255, 0.3),
    300: Color.fromRGBO(26, 143, 255, 0.4),
    400: Color.fromRGBO(26, 143, 255, 0.5),
    500: Color.fromRGBO(26, 143, 255, 0.6),
    600: Color.fromRGBO(26, 143, 255, 0.7),
    700: Color.fromRGBO(26, 143, 255, 0.8),
    800: Color.fromRGBO(26, 143, 255, 0.9),
    900: Color.fromRGBO(26, 143, 255, 1.0),
  };
  // This widget is the root of your application.
  static const MaterialColor _1A8FFF = MaterialColor(0xFF1A8FFF, colorMap);
  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: _initialization,
        builder: (context, snapshot) {
          if (snapshot.hasError) {
            return Stack(
              children: [
                new Positioned.fill(
                  child: Image.asset('assets/images/error_loading.jpg'),
                ),
                Align(
                  alignment: Alignment.center,
                  child: Text(
                    "Something Went Wrong",
                    style: TextStyle(
                        fontSize: 16,
                        fontFamily: 'RocknRollOne',
                        fontWeight: FontWeight.bold),
                  ),
                ),
              ],
            );
          }
          if (snapshot.connectionState == ConnectionState.done) {
            return MaterialApp(
              title: 'Church Fund Tracker',
              debugShowCheckedModeBanner: false,
              theme: ThemeData(
                  primarySwatch: _1A8FFF,
                  fontFamily: 'RocknRollOne',
                  visualDensity: VisualDensity.adaptivePlatformDensity),
              home: LoginPage(),
            );
          }
          return Loading();
        });
  }
}
