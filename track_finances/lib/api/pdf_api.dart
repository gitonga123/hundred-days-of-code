import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:path/path.dart';
import 'package:path_provider/path_provider.dart';
import 'package:http/http.dart' as http;
import 'dart:io';

class PDFApi {
  static Future<File> loadNetwork(Uri url) async {
    final response = await http.get(url);
    final bytes = response.bodyBytes;

    return _storeFile(url, bytes);
  }

  static Future<File> _storeFile(Uri url, List<int> bytes) async {
    String url_1 = url.toString();
    final filename = basename(url_1);
    final dir = await getApplicationDocumentsDirectory();

    final file = File('${dir.path}/$filename');
    await file.writeAsBytes(bytes, flush: true);
    return file;
  }
}
