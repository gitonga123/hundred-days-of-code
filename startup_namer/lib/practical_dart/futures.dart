Future<void> fetchUserOrder() {
  return Future.delayed(Duration(seconds: 2), () => print("Large Latter"));
}

void main() {
  fetchUserOrder();
  print("Fetching user order ...");
}
