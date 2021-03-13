import 'package:flutter/material.dart';

class MyHomePage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: new AppBar(
        title: new Text('News', style: TextStyle(
            fontWeight: FontWeight.bold,
          fontSize: 30,
            fontStyle: FontStyle.italic
        ),),
        centerTitle: true,
        elevation: 2,
      ),
    );
  }
}
