import 'package:flutter/material.dart';
import 'package:track_finances/screens/button_between_header_body.dart';
import 'package:track_finances/screens/header.dart';

class HomePage extends StatefulWidget {
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: new AppBar(
        elevation: 1,
        leading: IconButton(
            icon: const Icon(Icons.short_text),
            onPressed: () {
              print('Hello');
            }),
        centerTitle: true,
        title: const Text(
          'Development Fund',
          style: TextStyle(
              fontSize: 20,
              fontFamily: 'RocknRollOne',
              fontWeight: FontWeight.w400),
        ),
        actions: <Widget>[
          IconButton(
              icon: const Icon(Icons.person_outline_rounded),
              onPressed: () {
                print("Actions");
              })
        ],
      ),
      body: Column(
        children: [
          Header(),
          SizedBox(
            height: 10,
          ),
          ButtonsBetween()
        ],
      ),
    );
  }
}
