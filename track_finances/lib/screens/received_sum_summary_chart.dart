import 'package:flutter/material.dart';
import 'package:charts_flutter/flutter.dart' as charts;

class ReceivedSumSummaryChart extends StatelessWidget {
  final List<charts.Series> seriesList;
  final bool animate;

  const ReceivedSumSummaryChart(this.seriesList, {this.animate});
  @override
  Widget build(BuildContext context) {
    return charts.PieChart(
      seriesList,
      animate: animate,
      animationDuration: Duration(seconds: 1),
      defaultRenderer: charts.ArcRendererConfig(
          arcWidth: 50,
          strokeWidthPx: 0,
          arcRendererDecorators: [
            charts.ArcLabelDecorator(
                labelPadding: 50,
                showLeaderLines: false,
                outsideLabelStyleSpec: charts.TextStyleSpec(
                    fontSize: 12,
                    fontFamily: 'Nunito',
                    color: charts.MaterialPalette.white))
          ]),
      behaviors: [
        charts.DatumLegend(
            position: charts.BehaviorPosition.end,
            outsideJustification: charts.OutsideJustification.start,
            horizontalFirst: false,
            desiredMaxColumns: 1,
            cellPadding: const EdgeInsets.only(top: 15, right: 4, bottom: 1),
            entryTextStyle: charts.TextStyleSpec(
                fontSize: 12, color: charts.MaterialPalette.white))
      ],
    );
  }
}
