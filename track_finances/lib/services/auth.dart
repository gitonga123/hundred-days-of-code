import 'package:firebase_auth/firebase_auth.dart';
import 'package:track_finances/model/user.dart' as UserModel;

class AuthService {
  final FirebaseAuth _auth = FirebaseAuth.instance;
  UserModel.User _userFromFirebaseUser(User user) {
    return user != null ? UserModel.User(user.uid, user.email) : null;
  }

  // auth change user stream
  Stream<UserModel.User> get userStatus {
    return _auth
        .authStateChanges()
        .map(_userFromFirebaseUser);
  }
}
