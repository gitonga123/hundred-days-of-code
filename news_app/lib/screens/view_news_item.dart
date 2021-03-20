import 'dart:ui';
import 'dart:async';

import 'package:flutter/material.dart';
import 'package:news_app/model/news.dart';
import 'package:url_launcher/url_launcher.dart';


class NewsItem extends StatelessWidget {
  News news;
  NewsItem(this.news);
  @override
  Widget build(BuildContext context) {
    String image = news.image ?? 'https://th.bing.com/th/id/R456ff136e1fcf42d5c6faadf9a57f160?rik=89hbZBHlBz054Q&pid=ImgRaw';
    String title = news.title ?? 'Title Missing';
    String publisher = news.publisher ?? 'Publisher Missing';
    String text = news.text ?? 'Content Loading ...';
    String author = news.author ?? 'Author Loading ...';
    String date = news.date ?? 'Default Date not set';
    String urls = news.urls ?? 'Default url ...';
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: Scaffold(
        appBar: new AppBar(
          centerTitle: true,
          backgroundColor: Colors.white,
          leading: IconButton(
              icon: Icon(
                Icons.arrow_back_ios,
                size: 20,
                color: Colors.blue,
              ), onPressed: () => Navigator.pop(context)
          ),
          title: Text(
            title,
            style: TextStyle(
              color: Colors.black87,
              fontSize: 15,
              fontWeight: FontWeight.bold
            ),
          ),
        ),
        body: SingleChildScrollView(
          child: Center(
            child: Column(
              children: [
                Container(
                  height: 250,
                  width: MediaQuery.of(context).size.width,
                  margin: EdgeInsets.only(bottom: 10),
                  child: Image.network(
                    image,
                    fit: BoxFit.cover,
                  ),
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.only(
                      bottomRight: Radius.circular(15.0),
                      bottomLeft: Radius.circular(15.0)
                    )
                  ),
                ),
                ListTile(
                  title: Container(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          title,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 20
                          ),
                          textAlign: TextAlign.left,
                        ),
                        SizedBox(height: 8,),
                        Text(
                          publisher,
                          style: TextStyle(
                            color: Colors.black87
                          ),
                        ),
                        SizedBox(height: 12,),
                         Text(
                           text,
                           style: TextStyle(
                             wordSpacing: 2,
                             color: Colors.black
                           ),
                           textAlign: TextAlign.justify,
                         ),
                        SizedBox(
                          height: 12,
                        ),
                        Text(
                          "AUTHOR: $author"
                        ),
                        SizedBox(height: 12,),
                        Text(
                            'Date: $date'
                        ),
                        SizedBox(height: 12,),
                        Text(
                          'Full Story at'
                        ),
                        SizedBox(height: 5,),
                        InkWell(
                          child: Text(
                            urls,
                            style: TextStyle(
                              color: Colors.blue,
                            ),
                          ),
                          onTap: () async {
                            if (await canLaunch(urls)) {
                              await launch(urls);
                            }
                          },
                        )
                      ],
                    ),
                  ),
                )
              ],
            ),
          ),
        ),
      ),
    );
  }
}
