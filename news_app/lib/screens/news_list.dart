import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:news_app/model/news.dart';

class NewsList extends StatefulWidget {
  @override
  _NewsListState createState() => _NewsListState();
}

class _NewsListState extends State<NewsList> {
  static List<News> _news = List<News>.empty(growable: true);
  static List<News> _newsInApp = List<News>.empty(growable: true);

  Future<List<News>> comingNews() async {
    var url = 'http://www.mocky.io/v2/5ecfddf13200006600e3d6d0';
    var response = await http.get(url);
    var news = List<News>();
    if (response.statusCode == 200) {
      var newsJson = json.decode(response.body);
      for (var n in newsJson) {
        news.add(News.fromJson(n);
      }
    }

    return news;
  }
  @override
  Widget build(BuildContext context) {
    return Container();
  }
}
