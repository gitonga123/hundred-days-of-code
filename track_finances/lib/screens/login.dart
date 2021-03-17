import 'dart:core';
import 'package:flutter/cupertino.dart';
import 'package:flutter/services.dart';
// import 'package:flutter_vector_icons/flutter_vector_icons.dart' as vector_icons;
import 'package:flutter/material.dart';
import 'package:track_finances/config/constants.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:track_finances/screens/home_page.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:email_validator/email_validator.dart';

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final FirebaseAuth _auth = FirebaseAuth.instance;
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  String email, password;

  isUserLoggedIn() {
    if (FirebaseAuth.instance.currentUser != null) {
      Navigator.push(
          context, MaterialPageRoute(builder: (context) => HomePage()));
    }
  }

  @override
  void initState() {
    super.initState();
    Firebase.initializeApp().whenComplete(() {
      print("completed");
      setState(() {});
    });
    this.isUserLoggedIn();
  }

  login() async {
    ScaffoldMessenger
        .of(context)
        .showSnackBar(SnackBar(content: Text('Processing Data')));
    if (_formKey.currentState.validate()) {
      try {
        // UserCredential userCredential = await FirebaseAuth.instance
            // .signInWithEmailAndPassword(email: email, password: password);
      } on FirebaseAuthException catch (e) {
        if (e.code == 'user-not-found') {
          showError('No user Found for that email.');
        } else if (e.code == 'user-not-found') {
          showError('No user Found for that email.');
        }
      }
    }
  }

  void showError(String errorMessage) {
    showDialog(
        context: context,
        builder: (BuildContext context) {
          return AlertDialog(
            title: Text(
              'Error',
              style: TextStyle(
                  fontFamily: 'Nunito',
                  fontWeight: FontWeight.w900,
                  fontStyle: FontStyle.italic,
                  fontSize: 30,
                  color: Colors.redAccent),
            ),
            content: Text(
              errorMessage,
              style: TextStyle(
                  fontFamily: 'Nunito',
                  fontStyle: FontStyle.normal,
                  fontSize: 14,
                  fontWeight: FontWeight.w400),
            ),
            actions: [
              TextButton(
                  onPressed: () {
                    Navigator.of(context).pop();
                  },
                  child: Text('OK'))
            ],
          );
        });
  }

  Widget _buildLogo() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Padding(
          padding: const EdgeInsets.symmetric(vertical: 20),
          child: Text(
            'MCK Kangemi',
            style: TextStyle(
                fontFamily: 'Nunito',
                fontSize: MediaQuery.of(context).size.height / 25,
                fontWeight: FontWeight.w800,
                color: Colors.white),
          ),
        )
      ],
    );
  }

  Widget _buildSignUpBtn() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Padding(
          padding: EdgeInsets.only(top: 30),
          child: TextButton(
              onPressed: () => print(MediaQuery.of(context).size.height / 40),
              child: RichText(
                text: TextSpan(children: [
                  TextSpan(
                    text: "Don't have an account? ",
                    style: TextStyle(
                        color: Colors.black,
                        fontSize: 16,
                        fontWeight: FontWeight.w400,
                        fontFamily: 'Nunito'),
                  ),
                  TextSpan(
                      text: 'Sign Up',
                      style: TextStyle(
                          color: mainColor,
                          fontSize: 16,
                          fontWeight: FontWeight.bold,
                          fontFamily: 'Nunito'))
                ]),
              )),
        )
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
          resizeToAvoidBottomInset: false,
          backgroundColor: Color(0xfff2f3f7),
          body: Stack(
            children: [
              Container(
                height: MediaQuery.of(context).size.height * 0.7,
                width: MediaQuery.of(context).size.width,
                child: Container(
                  decoration: BoxDecoration(
                      color: mainColor,
                      borderRadius: BorderRadius.only(
                          bottomLeft: const Radius.circular(70),
                          bottomRight: const Radius.circular(70))),
                ),
              ),
              Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  _buildLogo(),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      ClipRRect(
                        borderRadius: BorderRadius.circular(15.0),
                        child: Container(
                          height: MediaQuery.of(context).size.height * 0.6,
                          width: MediaQuery.of(context).size.width * 0.8,
                          decoration: BoxDecoration(color: Colors.white),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  Text(
                                    "Login",
                                    style: TextStyle(
                                        fontSize:
                                            MediaQuery.of(context).size.height /
                                                30),
                                  )
                                ],
                              ),
                              Form(
                                  key: _formKey,
                                  child: Column(
                                    children: [
                                      Padding(
                                        padding: EdgeInsets.all(5),
                                        child: TextFormField(
                                          keyboardType:
                                              TextInputType.emailAddress,
                                          validator: (value) {
                                            if (value.isEmpty)
                                              return 'Enter Email';
                                            bool isValid =
                                                EmailValidator.validate(value);
                                            if (!isValid)
                                              return 'Enter a valid email';
                                            return null;
                                          },
                                          onChanged: (value) {
                                            setState(() {
                                              email = value;
                                            });
                                          },
                                          decoration: InputDecoration(
                                              prefixIcon: Icon(
                                                Icons.email,
                                                color: mainColor,
                                              ),
                                              labelText: 'E-mail'),
                                        ),
                                      ),
                                      Padding(
                                        padding: EdgeInsets.all(5),
                                        child: TextFormField(
                                          keyboardType: TextInputType.text,
                                          obscureText: true,
                                          validator: (value) {
                                            if (value.isEmpty) {
                                              return 'Enter Password';
                                            }
                                            return null;
                                          },
                                          onChanged: (value) {
                                            setState(() {
                                              password = value;
                                            });
                                          },
                                          decoration: InputDecoration(
                                              prefixIcon: Icon(
                                                Icons.lock,
                                                color: mainColor,
                                              ),
                                              labelText: 'Password'),
                                        ),
                                      ),
                                      SizedBox(
                                        height: 30,
                                      ),
                                      Row(
                                        mainAxisAlignment:
                                            MainAxisAlignment.center,
                                        children: [
                                          Container(
                                            height: 1.4 *
                                                (MediaQuery.of(context)
                                                        .size
                                                        .height /
                                                    20),
                                            width: 5 *
                                                (MediaQuery.of(context)
                                                        .size
                                                        .width /
                                                    10),
                                            margin: EdgeInsets.only(bottom: 15),
                                            child: ElevatedButton(
                                              onPressed: login,
                                              style: ElevatedButton.styleFrom(
                                                  primary: mainColor,
                                                  shadowColor: mainColor,
                                                  elevation: 5.0,
                                                  shape:
                                                      const BeveledRectangleBorder(
                                                          borderRadius:
                                                              BorderRadius.all(
                                                                  Radius
                                                                      .circular(
                                                                          5)))),
                                              child: Text(
                                                "Login",
                                                style: TextStyle(
                                                    color: Colors.white,
                                                    letterSpacing: 1.5,
                                                    fontSize:
                                                        MediaQuery.of(context)
                                                                .size
                                                                .height /
                                                            40),
                                              ),
                                            ),
                                          )
                                        ],
                                      )
                                    ],
                                  ))
                            ],
                          ),
                        ),
                      )
                    ],
                  ),
                  _buildSignUpBtn()
                ],
              )
            ],
          )),
    );
  }
}
