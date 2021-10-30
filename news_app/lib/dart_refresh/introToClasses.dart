class Person {
  String name, lastName, nationality, gender;
  int age;
  Person(this.name, this.lastName, this.nationality, this.age, this.gender);

  void showName() {
    print(this.name);
  }
}

class Daniel extends Person {
  String profession;
  Daniel(String name, String lastName, String nationality, int age,
      String gender, this.profession)
      : super(name, lastName, nationality, age, gender);

  void showProfession() => print(this.profession);
  String details() {
    return "${this.name} ${this.lastName} of ${this.nationality} origin aged ${this.age} and works as ${this.profession}";
  }
}

class Pamela extends Person {
  String favColor;
  Pamela(String name, String lastName, String nationality, int age,
      String gender, this.favColor)
      : super(name, lastName, nationality, age, gender);

  String _toString() {
    return(
        '${this.name} ${this.lastName} of ${this.nationality} origin aged ${this.age} and whose favourite color is ${this.favColor}');
  }
}

void main() {
  var pamela = new Pamela('Pamela', 'Mark', 'Kenyan', 32, 'Female', 'Blue');
  var daniel = new Daniel('Daniel', 'Mutwiri', 'Ugandan', 30, 'Male', 'Arts Professor');

  print(pamela._toString());
  print(daniel.details());
}
