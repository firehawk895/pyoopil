angular.module('uiApp')
  .controller('academicCtrl', ['$scope', '$stateParams' , 'roomService',
    function ($scope, $stateParams, roomService) {
      $scope.roomId = $stateParams.roomId;
      $scope.lastExpandedItemIndex = -1;
      $scope.currentGraphIndex = 0;
      roomService.getAcademicReport($scope.roomId).then(function (result) {
//        if (result.status) {
        $scope.academicReport = result.data;
        angular.forEach($scope.academicReport, function (value, key) {
          value.showContent = false;
          value.showGraph = false;
        });
        roomService.getGraph($scope.academicReport[0].Submission.id).then(function (graphResult) {
          if (graphResult.status) {
            if ($scope.academicReport[0].Submission.subjective_scoring == 'marked') {
              $scope.lineChartData = graphResult.graph.points;
              $scope.lineChartConfig = {
                options: {
                  chart: {
                    type: 'line'
                  }
                },
                series: [
                  {
                    data: $scope.lineChartData,
                    color: '#ff992f',
                    name: 'Marks'
                  }
                ],
                xAxis: {
                  title: {
                    text: 'Percentile'
                  }
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Marks'
                  },
                  plotLines: [
                    {
                      color: '#A0A0A0',
                      width: 4,
                      value: $scope.academicReport[0].Submission.average_marks // Need to set this probably as a var.
                    }
                  ]
                },
                title: {
                  text: 'Relative to Class'
                },
                loading: false
              };
              var obj = {
                x: graphResult.graph.marked.x,
                y: graphResult.graph.marked.y,
                color: "#A0A0A0"
              };
              angular.forEach($scope.lineChartData, function (value, key) {
                if (value.x == graphResult.graph.marked.x && value.y == graphResult.graph.marked.y)
                  $scope.indexOfObject = key;
              });
              $scope.lineChartConfig.series[0].data[$scope.indexOfObject] = obj;
            }
            else if ($scope.academicReport[0].Submission.subjective_scoring == 'graded') {
              var chartData = [];
              var categoryData = [];
              angular.forEach(graphResult.graph.frequency, function (value, key) {
                chartData.push(parseInt(value));
                categoryData.push(key);
              });
              $scope.columnChartConfig = {
                options: {
                  chart: {
                    type: 'column'
                  },
                  legend: {
                    align: 'right',
                    verticalAlign: 'top'
                  },
                  plotOptions: {
                    column: {
                      pointPadding: 0.2,
                      borderWidth: 0
                    }
                  }
                },
                title: {
                  text: 'Academic Report Relative to Class'
                },
                xAxis: {
                  categories: categoryData,
                  title: {
                    text: 'Grades'
                  }
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Frequency(Number of Students)'
                  }
                },
                tooltip: {
                  headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                  pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                  footerFormat: '</table>',
                  shared: true,
                  useHTML: true
                },

                series: [
                  {
                    name: 'Students',
                    data: chartData,
                    color: '#ff992f'
                  }
                ]
              };
              var obj = {
                y: chartData[categoryData.indexOf(graphResult.graph.marked)],
                color: "#A0A0A0"
              };
              $scope.columnChartConfig.series[0].data[categoryData.indexOf(graphResult.graph.marked)] = obj;
            }
            $scope.academicReport[0].showGraph = true;
          }
        });

        //        }
      });

      $scope.displayContent = function (index) {
        if ($scope.lastExpandedItemIndex == -1) {
          $scope.lastExpandedItemIndex = index;
          $scope.academicReport[index].showContent = true;
        }
        else if ($scope.lastExpandedItemIndex == index) {
          $scope.lastExpandedItemIndex = -1;
          $scope.academicReport[index].showContent = false;
        }
        else {
          $scope.academicReport[$scope.lastExpandedItemIndex].showContent = false;
          $scope.academicReport[index].showContent = true;
          $scope.lastExpandedItemIndex = index;
        }
      };

      $scope.displayGraph = function (index) {
        if ($scope.currentGraphIndex !== index) {
          roomService.getGraph($scope.academicReport[index].Submission.id).then(function (graphResult) {
            if (graphResult.status) {
              if ($scope.academicReport[index].Submission.subjective_scoring == 'marked') {
                $scope.lineChartData = graphResult.graph.points;
                $scope.lineChartConfig = {
                  options: {
                    chart: {
                      type: 'line'
                    },
                    legend: {
                      enabled: false
                    }
                  },
                  series: [
                    {
                      data: $scope.lineChartData,
                      color: '#ff992f'
                    }
                  ],
                  xAxis: {
                    title: {
                      text: 'Percentile'
                    }
                  },
                  yAxis: {
                    min: 0,
                    title: {
                      text: 'Marks'
                    },
                    plotLines: [
                      {
                        color: '#A0A0A0',
                        width: 4,
                        value: $scope.academicReport[0].Submission.average_marks // Need to set this probably as a var.
                      }
                    ]
                  },
                  title: {
                    text: 'Relative to Class'
                  },
                  loading: false
                };
                var obj = {
                  x: graphResult.graph.marked.x,
                  y: graphResult.graph.marked.y,
                  color: "#A0A0A0"
                };
                angular.forEach($scope.lineChartData, function (value, key) {
                  if (value.x == graphResult.graph.marked.x && value.y == graphResult.graph.marked.y)
                    $scope.indexOfObject = key;
                });
                $scope.lineChartConfig.series[0].data[$scope.indexOfObject] = obj;
              }
              else if ($scope.academicReport[index].Submission.subjective_scoring == 'graded') {
                var chartData = [];
                var categoryData = [];
                angular.forEach(graphResult.graph.frequency, function (value, key) {
                  chartData.push(parseInt(value));
                  categoryData.push(key);
                });
                $scope.columnChartConfig = {
                  options: {
                    chart: {
                      type: 'column'
                    },
                    legend: {
                      align: 'right',
                      verticalAlign: 'top'
                    },
                    plotOptions: {
                      column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                      }
                    }
                  },
                  title: {
                    text: 'Academic Report Relative to Class'
                  },
                  xAxis: {
                    categories: categoryData,
                    title: {
                      text: 'Grades'
                    }
                  },
                  yAxis: {
                    min: 0,
                    title: {
                      text: 'Frequency(Number of Students)'
                    }
                  },
                  tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                      '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                  },

                  series: [
                    {
                      name: 'Students',
                      data: chartData,
                      color: '#ff992f'
                    }
                  ]
                };
                var obj = {
                  y: chartData[categoryData.indexOf(graphResult.graph.marked)],
                  color: "#A0A0A0"
                };
                $scope.columnChartConfig.series[0].data[categoryData.indexOf(graphResult.graph.marked)] = obj;
              }
              $scope.academicReport[$scope.currentGraphIndex].showGraph = false;
              $scope.academicReport[index].showGraph = true;
              $scope.currentGraphIndex = index;
            }
          });
        }
      };
    }]);