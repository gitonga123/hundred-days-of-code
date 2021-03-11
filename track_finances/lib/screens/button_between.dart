import 'package:flutter/material.dart';

class ButtonBetween extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      child:  TextButton(
        onPressed: () {},
        child: Container(
          height: 50,
          color: Colors.redAccent,
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                'Cell',
                style: TextStyle(
                    fontSize: 20,
                    fontFamily: 'Nunito',
                    color: Colors.white,
                    fontWeight: FontWeight.w800),
              ),
              Icon(
                Icons.add_location_alt,
                color: Colors.white,
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
    );
  }
}
