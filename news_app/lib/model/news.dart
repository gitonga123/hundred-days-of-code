class News {
  String id;
  String urls;
  String titles;
  String text;
  String published;
  String author;
  String image;
  String date;

  News(this.id, this.urls, this.titles, this.text, this.published, this.author,
      this.image, this.date);
  News.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    urls = json['urls'];
    titles = json['title'];
    text = json['text'];
    published = json['published'];
    author = json['author'];
    image = json['image'];
    date = json['date'];
  }
}
