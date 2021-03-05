import 'dart:ui';

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
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text("Ksh. ",
                  style: TextStyle(
                      color: Colors.white,
                      fontFamily: 'Nunito',
                      fontSize: 50,
                      fontWeight: FontWeight.w700,
                      fontStyle: FontStyle.normal)),
              SizedBox(
                width: 0.5,
              ),
              Text("500, 000 /=",
                  style: TextStyle(
                      color: Colors.white,
                      fontFamily: 'Nunito',
                      fontSize: 50,
                      fontWeight: FontWeight.w700,
                      fontStyle: FontStyle.normal)),
            ],
          ),
          Text("Total Account Balance",
              style: TextStyle(
                  color: Colors.white.withOpacity(0.5),
                  fontFamily: 'Nunito',
                  fontSize: 30,
                  fontWeight: FontWeight.w700,
                  fontStyle: FontStyle.normal)),
          SizedBox(
            height: 10,
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Expanded(
                child: OutlineButton(
                  onPressed: () {
                    print("Add new transaction");
                  },
                  borderSide: const BorderSide(width: 1, color: Colors.white),
                  shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(24)),
                  child: Container(
                    width: mediaQuery.size.width * 0.1,
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Icon(
                          Icons.playlist_add,
                          color: Colors.white,
                        ),
                        const SizedBox(
                          width: 4,
                        ),
                        const Text(
                          "Add Transaction",
                          style: TextStyle(
                              fontSize: 14,
                              fontFamily: 'Nunito',
                              color: Colors.white,
                              fontWeight: FontWeight.bold),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
              SizedBox(
                width: 10,
              ),
              Expanded(
                child: TextButton(
                  onPressed: () {},
                  child: Container(
                    width: mediaQuery.size.width * 0.055,
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.end,
                      children: [
                        Text(
                          'Reports',
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
              )
            ],
          ),
          SizedBox(
            height: 15,
          ),
        ],
      ),
    );

    // return Container(
    //   width: double.infinity,
    //   height: mediaQuery.size.height * .4,
    //   color: primaryColor,
    //   child: Padding(
    //     padding: const EdgeInsets.all(12),
    //     child: Column(
    //       crossAxisAlignment: CrossAxisAlignment.start,
    //       children: [Card()],
    //     ),
    //   ),
    // );
  }
}
