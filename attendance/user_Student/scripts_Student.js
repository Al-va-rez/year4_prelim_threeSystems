// input field styles
    $('.inputBox').addClass('border border-gray-500 rounded-md focus:cursor-none focus:outline-blue-500');

    $('.inputField').addClass('flex flex-col w-full text-xl');
// input field styles


    $('#createEnrollmentForm').on('submit',
        function(event) {
            event.preventDefault();

            var formData = {
                student_username: $('#formStudentUsername').val(),
                course_title: $('#formCourseTitle').val(),
                enrollReq: 1
            };


            $.ajax(
                {
                    type: "POST",
                    url: "../core/handleForms.php",
                    data: formData,
                    success: function(data) {
                        data = data.trim();
                        switch (data) {
                            case 'Success':
                                alert("Enrolled to course!");
                                setTimeout(function() {
                                    window.location.href = "index.php";
                                }, 500);
                                break;
                        
                            default:
                                console.log('something went wrong');
                                console.log(data);
                                break;
                        }
                        
                    }
                }
            )
        }
    )

    $('#createAttendanceForm').on('submit',
        function(event) {
            event.preventDefault();

            var formData = {
                year_level: $('#formYearLevel').val(),
                student_username: $('#formStudentUsername').val(),
                course_title: $('#formEnrolledCourseTitle').val(),
                attendance_Status: $('#formAttendanceStatus').val(),
                excuseLetter: $('#formExcuseLetter').val(),  // include excuse letter
                attendanceReq: 1
            };


            $.ajax(
                {
                    type: "POST",
                    url: "../core/handleForms.php",
                    data: formData,
                    success: function(data) {
                        data = data.trim();
                        switch (data) {
                            case 'Success':
                                alert("Attendance filed!");
                                setTimeout(function() {
                                    window.location.href = "index.php";
                                }, 500);
                                break;
                        
                            case 'handleForms issue':
                                console.log(data);
                                break;
                        
                            default:
                                console.log('ajax issue');
                                console.log(JSON.stringify(data));
                                break;
                        }
                        
                    }
                }
            )
        }
    )

    // show or hide textarea for excuse letter
    $('#formAttendanceStatus').on('change',
        function (event) {
            event.preventDefault();

            if ($(this).val() === "Absent") {
                $('#formExcuseLetter').removeClass("hidden").attr("required", "required");
            } else {
                
                $('#formExcuseLetter').addClass("hidden").removeAttr("required").val("");
            }
        }
    )

    $(document).on('submit', '.viewExcuseLetter',
        function (event) {
            event.preventDefault();

            var formData = {
                student_username: $(this).find('.letter_StudentName').val(),
                course_title: $(this).find('.letter_CourseTitle').val(),
                date_submitted: $(this).find('.letter_DateSubmitted').val(),
                getLetterReq: 1
            };

            $.ajax(
                {
                    type: "POST",
                    url: "../core/handleForms.php",
                    data: formData,
                    success: function(data) {
                        $("#windowExcuseLetter").removeClass("hidden");
                        $('#letterCourse').append(`<span class="font-bold">Course: ${data.course_title}</span>`);
                        switch (data.status) {
                            case "Approved":
                                $('#letterStatus').append(`<span class="text-green-700">STATUS: ${data.status}</span>`);
                                break;
                        
                            case "Denied":
                                $('#letterStatus').append(`<span class="text-red-600">STATUS: ${data.status}</span>`);
                                break;
                        
                            default:
                                $('#letterStatus').append(`<span class="text-yellow-600">STATUS: ${data.status}</span>`);
                                break;
                        }
                        $('#letterBody').append(`${data.letter}`);
                    }
                }
            )
        }
    )

    $("#closeExcuseLetter").on('click',
        function (event) {
            event.preventDefault();
            $("#windowExcuseLetter").addClass("hidden");
            $("#letterCourse").html("");
            $("#letterStatus").html("");
            $("#letterBody").html("");
        }
    )