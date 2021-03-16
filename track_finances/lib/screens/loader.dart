import 'package:flutter/material.dart';
import 'package:blurhash_flutter/blurhash.dart' as blurhash;

class Loading extends StatefulWidget {
  @override
  _LoadingState createState() => _LoadingState();
}

class _LoadingState extends State<Loading> {
  static const hash = r"LqNnB$a}~Vj[xaj[oefQ^*fQofoL";

  @override
  Widget build(BuildContext context) {
    return Center(
        child: Image.memory(blurhash.Decoder.decode(
      hash,
      MediaQuery.of(context).size.height.toInt(),
      MediaQuery.of(context).size.height.toInt(),
    )));
  }
}
