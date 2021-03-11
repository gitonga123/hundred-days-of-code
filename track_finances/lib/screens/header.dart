import 'dart:ui';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class Header extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final primaryColor = Theme.of(context).primaryColor;
    final mediaQuery = MediaQuery.of(context);
    return Container(
      padding: EdgeInsets.symmetric(horizontal: 50),
      width: mediaQuery.size.width,
      decoration: BoxDecoration(
          color: primaryColor,
          borderRadius: BorderRadius.only(
              bottomLeft: Radius.circular(50),
              bottomRight: Radius.circular(50))),
      child: Column(
        children: [
          Text(
            'Ksh. 500K',
            style: TextStyle(
                color: Colors.white,
                fontFamily: 'Nunito',
                fontSize: 50,
                fontWeight: FontWeight.w700,
                fontStyle: FontStyle.normal),
          ),
          Text("Account Balance",
              style: TextStyle(
                  color: Colors.white.withOpacity(0.5),
                  fontFamily: 'Nunito',
                  fontSize: 30,
                  fontWeight: FontWeight.bold,
                  fontStyle: FontStyle.italic)),
          SizedBox(
            height: 10,
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded(
                child: OutlinedButton(
                  onPressed: () {
                    print("Add new transaction");
                  },
                  style: OutlinedButton.styleFrom(
                      primary: Colors.black,
                      backgroundColor: Colors.white,
                      shape: const RoundedRectangleBorder(
                          borderRadius: BorderRadius.all(Radius.circular(24)))),
                  child: Container(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Icon(
                          Icons.playlist_add,
                          color: Colors.black,
                        ),
                        const SizedBox(
                          width: 2,
                        ),
                        const Text(
                          "Add Transaction",
                          style: TextStyle(
                              fontSize: 12,
                              fontFamily: 'Nunito',
                              color: Colors.black,
                              fontWeight: FontWeight.bold),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
              const SizedBox(width: 10,),
              Expanded(
                child: OutlinedButton(
                  onPressed: () {
                    print("Add new transaction");
                  },
                  style: OutlinedButton.styleFrom(
                      primary: Colors.redAccent,
                      backgroundColor: Colors.redAccent,
                      shape: const RoundedRectangleBorder(
                          borderRadius: BorderRadius.all(Radius.circular(24)))),
                  child: Container(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Text(
                          "Reports",
                          style: TextStyle(
                              fontSize: 18,
                              fontFamily: 'Nunito',
                              color: Colors.white,
                              fontWeight: FontWeight.bold),
                        ),
                        const SizedBox(
                          width: 2,
                        ),
                        const Icon(
                          Icons.arrow_forward,
                          color: Colors.white,
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ],
          ),
          SizedBox(
            height: 15,
          ),
        ],
      ),
    );
  }
}
