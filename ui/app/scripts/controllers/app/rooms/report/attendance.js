angular.module('uiApp')
  .controller('attendanceCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.vm = {};
      $scope.vm.isPersonal = true;
      $scope.roomId = $stateParams.roomId;
      roomService.getAttendanceReport($scope.roomId).then(function (result) {
        if (result.status) {
          $scope.attendanceReport = result.data;
          $scope.vm.missed = $scope.attendanceReport.Classroom.classes_held - $scope.attendanceReport.UsersClassroom.classes_attended;
          $scope.vm.attendancePercentage = ($scope.attendanceReport.UsersClassroom.classes_attended * 100 / $scope.attendanceReport.Classroom.classes_held);
          var chartData = [];
          var categoryData = [];
          angular.forEach(result.graph.frequency, function (value, key) {
            chartData.push(parseInt(value));
            categoryData.push(key);
          });
          console.log(chartData);
          $scope.donutChartConfig = {
            options: {
              chart: {
                renderTo: 'container',
                type: 'pie'
              }
            },
            title: {
              text: 'Number of Students Attended Classes'
            },
            plotOptions: {
              pie: {
                shadow: false
              }
            },
            tooltip: {
              formatter: function () {
                return '<b>' + this.point.name + '</b>: ' + this.y + ' %';
              }
            },
            legend: {
              align: 'right',
              verticalAlign: 'top'
            },
            series: [
              {
                data: [
                  ["Missed", $scope.vm.missed * 100 / $scope.attendanceReport.Classroom.classes_held],
                  ["Attended", $scope.vm.attendancePercentage]
                ],
                size: '80%',
                innerSize: '45%',
                showInLegend: true,
                colors: [
                  '#ff992f',
                  '#A0A0A0'
                ]
//              dataLabels: {
//                formatter: function () {
//                  return '</b>: ' + this.y + ' %';
//                },
//                color: 'white',
//                distance: -30
//              }
              }
            ]

          };
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
              text: 'Attendance Report Relative to Class'
            },
            xAxis: {
              categories: categoryData,
              title: {
                text: 'Mark Interval'
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
        }

      });

    }]);
