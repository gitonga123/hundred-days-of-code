import 'dart:io';

void main(List<String> args) {
  print("What is your name?;");
  String? name = stdin.readLineSync();
  print(name);

  print("Hello ${name}");
}
