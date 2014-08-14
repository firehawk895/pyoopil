angular.module 'Pyoopil.Services'
  .factory 'classroomService', ['Base', (Base)->

    new class ClassroomService extends Base

      constructor : ->

        super

        @path += 'Classrooms/'

      getData : (url, data)->

        path = @path + url

        super(path, data)

      postData : (url, data)->

        path = @path + url

        super(url, data)

      getClassrooms : (pageNo)->

        url = 'getclassrooms.json?page=' + pageNo

        @getData(url)


      newClassroom : (data)->

        url = 'add.json'

        @postData(url, data)


      joinClassroom : (data)->

        url = 'join.json'

        @postData(url, data)











  ]