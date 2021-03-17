import 'package:firebase_auth/firebase_auth.dart';
import 'package:track_finances/model/user.dart' as UserModel;

class AuthService {
  final FirebaseAuth _auth = FirebaseAuth.instance;
  UserModel.User _userFromFirebaseUser(User user) {
    return user != null ? UserModel.User(user.uid, user.email) : null;
  }

  // auth change user stream
  Stream<UserModel.User> get userStatus {
    return _auth.authStateChanges().map(_userFromFirebaseUser);
  }

  Future logout() async {
    try {
      return await _auth.signOut();
    } catch (e) {
      print(e.toString());
      return null;
    }
  }

  Future loginWithEmailAndPassword(String email, String password) async {
    try {
      UserCredential userCredential = await _auth
          .signInWithEmailAndPassword(email: email, password: password);
      User user = userCredential.user;
      return _userFromFirebaseUser(user);
    } catch (e) {
      return null;
    }
  }

  Future registerWithEmailAndPassword(String email, String password) async {
    try {
      UserCredential userCredential = await _auth
          .createUserWithEmailAndPassword(email: email, password: password);
      User user = userCredential.user;
      return _userFromFirebaseUser(user);
    } catch (e) {
      print(e.toString());
      return null;
    }
  }
}
