import 'package:flutter/cupertino.dart';
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
    var url = Uri.parse("http://www.mocky.io/v2/5ecfddf13200006600e3d6d0");
    var response = await http.get(url);
    var news = List<News>.empty(growable: true);
    if (response.statusCode == 200) {
      var newsJson = json.decode(response.body);
      for (var n in newsJson) {
        news.add(News.fromJson(n));
      }
    }

    return news;
  }

  @override
  void initState() {
    comingNews().then((value) {
      setState(() {
        _news.addAll(value);
        _newsInApp = _news;
      });
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return ListView.separated(
      padding: const EdgeInsets.all(6),
      itemBuilder: (context, index) {
        return _listNews(index);
      },
      itemCount: _newsInApp.length,
      separatorBuilder: (BuildContext context, int index) => const Divider(),
    );
  }

  Widget _listNews(index) {
    return Row(
      children: [
        Expanded(
          child: ListTile(
            title: Text(
              _news[index].titles,
              style: TextStyle(fontWeight: FontWeight.w800, fontSize: 20),
            ),
            subtitle: Text(
              _news[index].author,
              style: TextStyle(
                  fontWeight: FontWeight.w400,
                  fontStyle: FontStyle.normal,
                  fontSize: 16),
            ),
            trailing: IconButton(
                iconSize: 16,
                color: Colors.black87,
                alignment: Alignment.center,
                icon: Icon(Icons.arrow_forward_ios),
                onPressed: () => print("Am clicked")
            ),
          ),
        ),
      ],
    );
  }
}
