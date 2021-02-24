import 'dart:ui';
import 'dart:async';

import 'package:flutter/material.dart';

void main() => runApp(MyApp());

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Tomato Timer',
      theme: ThemeData(
        primarySwatch: Colors.yellow,
        brightness: Brightness.light
      ),
      themeMode: ThemeMode.dark,
      darkTheme: ThemeData(
        brightness: Brightness.dark
      ),
      home: Scaffold(

      ),
    );
  }
}
