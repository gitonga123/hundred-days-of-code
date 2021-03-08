import 'package:flutter/material.dart';
import 'package:track_finances/screens/home_page.dart';
import 'package:track_finances/widget/button_widget.dart';

void main() {
  runApp(MianPage());
}

class MianPage extends StatefulWidget {
  @override
  _MianPageState createState() => _MianPageState();
}

class _MianPageState extends State<MianPage> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'PDF Viewer',
      debugShowCheckedModeBanner: false,
      home: Scaffold(
        body: Center(
          child: Padding(
            padding: EdgeInsets.all(32),
            child: Column(
              children: [
                ButtonWidget(
                  "Asset PDF", () => {

                  }
                ),
                SizedBox(height: 16,),
                ButtonWidget(
                  "File PDF", () => {

                  }
                ),
                SizedBox(height: 16,),
                ButtonWidget(
                  "Network PDF", () => {

                  }
                ),
                SizedBox(height: 16,),
                ButtonWidget(
                  "Firebase PDF", () => {

                  }
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget ButtonWidget(String text, () {}) {

  }
}

class MyApp extends StatelessWidget {
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
    return MaterialApp(
      title: 'Church Fund Tracker',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
          primarySwatch: _1A8FFF,
          fontFamily: 'RocknRollOne',
          visualDensity: VisualDensity.adaptivePlatformDensity),
      home: HomePage(),
    );
  }
}
