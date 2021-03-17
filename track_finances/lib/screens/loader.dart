import 'package:flutter/material.dart';
import 'package:flutter_blurhash/flutter_blurhash.dart';

class Loading extends StatefulWidget {
  final int height;
  final int width;
  const Loading({Key key, this.height, this.width}) : super(key: key);
  @override
  _LoadingState createState() =>
      _LoadingState(height: this.height, width: this.width);
}

class _LoadingState extends State<Loading> {
  int height;
  int width;
  _LoadingState({this.height, this.width});
  static const hash = r"LqNnB$a}~Vj[xaj[oefQ^*fQofoL";

  @override
  Widget build(BuildContext context) {
    return Container(
        child: BlurHash(
          hash: hash,
        )
    );
  }
}