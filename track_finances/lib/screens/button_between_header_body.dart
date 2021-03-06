import 'package:flutter/material.dart';

class ButtonsBetween extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final primaryColor = Theme.of(context).primaryColor;
    final mediaQuery = MediaQuery.of(context);
    return Container(
      width: mediaQuery.size.width,
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Expanded(
            child: TextButton(
              onPressed: () {},
              child: Container(
                height: 50,
                width: 300,
                color: Colors.green,
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Text(
                      'Cell',
                      style: TextStyle(
                          fontSize: 12,
                          fontFamily: 'Nunito',
                          color: Colors.black,
                          fontWeight: FontWeight.w600),
                    ),
                    Icon(
                      Icons.navigate_next,
                      color: Colors.black,
                    ),
                  ],
                ),
              ),
              style: TextButton.styleFrom(
                  primary: Colors.black,
                  backgroundColor: Colors.white,
                  shape: const BeveledRectangleBorder(
                      borderRadius: BorderRadius.all(Radius.circular(4)))),
            ),
          ),
          Expanded(
            child: TextButton(
              onPressed: () {},
              child: Container(
                height: 50,
                width: 300,
                color: Colors.yellow,
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Text(
                      'Groups',
                      style: TextStyle(
                          fontSize: 12,
                          fontFamily: 'Nunito',
                          color: Colors.black,
                          fontWeight: FontWeight.w600),
                    ),
                    Icon(
                      Icons.navigate_next,
                      color: Colors.black,
                    ),
                  ],
                ),
              ),
              style: TextButton.styleFrom(
                  primary: Colors.black,
                  backgroundColor: Colors.white,
                  shape: const BeveledRectangleBorder(
                      borderRadius: BorderRadius.all(Radius.circular(4)))),
            ),
          ),
          Expanded(
            child: TextButton(
              onPressed: () {},
              child: Container(
                height: 50,
                width: 300,
                color: Colors.blue,
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Text(
                      'Development',
                      style: TextStyle(
                          fontSize: 12,
                          fontFamily: 'Nunito',
                          color: Colors.black,
                          fontWeight: FontWeight.w600),
                    ),
                    Icon(
                      Icons.navigate_next,
                      color: Colors.black,
                    ),
                  ],
                ),
              ),
              style: TextButton.styleFrom(
                  primary: Colors.black,
                  backgroundColor: Colors.white,
                  shape: const BeveledRectangleBorder(
                      borderRadius: BorderRadius.all(Radius.circular(4)))),
            ),
          ),
          Expanded(
            child: TextButton(
              onPressed: () {},
              child: Container(
                height: 50,
                width: 300,
                color: Colors.red,
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Text(
                      'Others',
                      style: TextStyle(
                          fontSize: 12,
                          fontFamily: 'Nunito',
                          color: Colors.black,
                          fontWeight: FontWeight.w600),
                    ),
                    Icon(
                      Icons.navigate_next,
                      color: Colors.black,
                    ),
                  ],
                ),
              ),
              style: TextButton.styleFrom(
                  primary: Colors.black,
                  backgroundColor: Colors.white,
                  shape: const BeveledRectangleBorder(
                      borderRadius: BorderRadius.all(Radius.circular(24)))),
            ),
          )
        ],
      ),
    );
  }
}
