import 'package:flutter/material.dart';
import 'package:english_words/english_words.dart';

void main() => runApp(ExpandedWidget());

class AnimatedContainerWidget extends StatefulWidget {
  @override
  _AnimatedContainerWidgetState createState() =>
      _AnimatedContainerWidgetState();
}

class _AnimatedContainerWidgetState extends State<AnimatedContainerWidget> {
  final _myDuration = Duration(seconds: 1);
  var _myValue = Color(0xFF00bb00);
  final _myNewValue = Color(0xFF0000FF);
  @override
  Widget build(BuildContext context) {
    return Stack(
      children: <Widget>[
        Center(
          child: AnimatedContainer(
            color: _myValue,
            duration: _myDuration,
            child: SomeOtherWidget(),
          ),
        ),
        updateStateButton()
      ],
    );
  }

  Align updateStateButton() {
    return Align(
      alignment: Alignment.bottomCenter,
      child: Padding(
        padding: EdgeInsets.only(bottom: 100),
        child: RaisedButton(
          onPressed: () {
            setState(() {
              _myValue = _myNewValue;
            });
          },
          child: Text('Update State'),
        ),
      ),
    );
  }
}

class SomeOtherWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: 200,
      height: 200,
    );
  }
}

class WrapWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        appBar: AppBar(
          title: Text("Flutter Widget of the Week: Wrap"),
        ),
        body: SafeArea(
            child: Container(
          color: Colors.amber[100],
          child: Wrap(
            alignment: WrapAlignment.start,
            direction: Axis.horizontal,
            spacing: 8.0,
            runSpacing: 5.0,
            children: <Widget>[
              Container(
                color: Colors.amber,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.black,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.blue,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.brown,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.cyan,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.deepOrange,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.deepPurple,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.green,
                width: 80,
                height: 80,
              ),
              Container(
                color: Colors.teal,
                width: 80,
                height: 80,
              )
            ],
          ),
        )),
      ),
    );
  }
}

class ExpandedWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        appBar: AppBar(
          title: Text('Flutter Widget of the week: Expanded'),
        ),
        body: SafeArea(
          child: Column(
            children: <Widget>[
              Container(
                color: Colors.green,
                width: 150,
                height: 140,
                child: Center(
                  child: Text(
                    'Container Widget 1',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                        color: Colors.white,
                        fontSize: 27,
                        fontWeight: FontWeight.bold),
                  ),
                ),
              ),
              Container(
                color: Colors.blue,
                width: 150,
                height: 140,
                child: Center(
                  child: Text(
                    'Container Widget 2',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                        color: Colors.white,
                        fontSize: 27,
                        fontWeight: FontWeight.bold),
                  ),
                ),
              ),
              Expanded(
                  child: Container(
                color: Colors.pink,
                child: Center(
                  child: Text(
                    'Container Widget 3',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                        color: Colors.white,
                        fontSize: 27,
                        fontWeight: FontWeight.bold),
                  ),
                ),
              ))
            ],
          ),
        ),
      ),
    );
  }
}

class SafeAreaWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        appBar: AppBar(
          title: Text('Widget of the Week: SafeArea'),
        ),
        body: SafeArea(
            child: Center(
          child: Text(
            'Example of SafeArea Widget in Flutter',
            style: TextStyle(fontSize: 26, color: Colors.black),
            textAlign: TextAlign.center,
          ),
        )),
      ),
    );
  }
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Startup Name Generator',
      theme: ThemeData(primaryColor: Colors.white),
      home: RandomWords(),
    );
  }
}

class RandomWords extends StatefulWidget {
  @override
  _RandomWordsState createState() => _RandomWordsState();
}

class _RandomWordsState extends State<RandomWords> {
  final List<WordPair> _suggestions = <WordPair>[];
  final TextStyle _biggerFont = const TextStyle(fontSize: 18);
  final _saved = Set<WordPair>();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Startup Name Generator'),
        actions: <Widget>[
          IconButton(icon: Icon(Icons.list), onPressed: _pushSaved)
        ],
      ),
      body: SafeArea(child: _buildSuggestions()),
    );
  }

  void _pushSaved() {
    Navigator.of(context)
        .push(MaterialPageRoute(builder: (BuildContext context) {
      final tiles = _saved.map((WordPair pair) {
        return ListTile(title: Text(pair.asPascalCase, style: _biggerFont));
      });
      final divided =
          ListTile.divideTiles(tiles: tiles, context: context).toList();
      return Scaffold(
          appBar: AppBar(title: Text('Saved Suggestions')),
          body: ListView(children: divided));
    }));
  }

  Widget _buildSuggestions() {
    return ListView.builder(
        padding: const EdgeInsets.all(16),
        itemBuilder: (BuildContext _context, int i) {
          if (i.isOdd) {
            return Divider();
          }
          final int index = i ~/ 2;
          if (index >= _suggestions.length) {
            _suggestions.addAll(generateWordPairs().take(10));
          }
          return _buildRow(_suggestions[index]);
        });
  }

  Widget _buildRow(WordPair pair) {
    final alreadySaved = _saved.contains(pair);
    return ListTile(
      onTap: () {
        setState(() {
          if (alreadySaved) {
            _saved.remove(pair);
          } else {
            _saved.add(pair);
          }
        });
      },
      title: Text(
        pair.asPascalCase,
        style: _biggerFont,
      ),
      trailing: Icon(
        alreadySaved ? Icons.favorite : Icons.favorite_border,
        color: alreadySaved ? Colors.red : null,
      ),
    );
  }
}
