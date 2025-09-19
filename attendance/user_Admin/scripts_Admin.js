// input field styles
    $('.inputBox').addClass('border border-gray-500 rounded-md focus:cursor-none focus:outline-blue-500');

    $('.inputField').addClass('flex flex-col w-full text-xl');
// input field styles


    $('#createCourseForm').on('submit',
        function(event) {
            event.preventDefault();

            var formData = {
                courseCode: $('#formCourseCode').val(),
                courseTitle: $('#formCourseTitle').val(),
                courseUnits: $('#formCourseUnits').val(),
                courseReq: 1
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
                                alert("Course created!");
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
    );

    $('#filterAttendanceForm').on('submit',
        function(event) {
            event.preventDefault();

            var formData = {
                course: $('#formEnrolledCourseTitle').val(),
                year_level: $('#formYearLevel').val(),
                attendance_Status: $('#formAttendanceStatus').val(),
                filterReq: 1
            };


            $.ajax(
                {
                    type: "POST",
                    url: "../core/handleForms.php",
                    data: formData,
                    success: function(data) {
                        let tbody = $("#attendanceTable tbody");
                        tbody.empty(); // clear current rows

                        if (data.length > 0) {
                            data.forEach((row) => {
                                let remarksCell = "";

                                if (!row.remarks || row.remarks.trim() === "") {
                                    // if remarks is empty → show form
                                    remarksCell = `
                                        <form class="viewExcuseLetter">
                                            <input type="hidden" class="letter_StudentName" value="${row.student_username}">
                                            <input type="hidden" class="letter_CourseTitle" value="${row.course_title}">
                                            <input type="hidden" class="letter_DateSubmitted" value="${row.date_filed}">
                                            <button class="px-6 py-2 bg-yellow-500 rounded-full text-lg text-white font-semibold hover:bg-yellow-600">
                                                View Excuse Letter
                                            </button>
                                        </form>
                                    `;
                                } else {
                                    // if remarks has value → just show it
                                    remarksCell = row.remarks;
                                }

                                tbody.append(`
                                    <tr class="text-center">
                                        <td class="border p-2">${row.id}</td>
                                        <td class="border p-2">${row.year_level}</td>
                                        <td class="border p-2">${row.student_username}</td>
                                        <td class="border p-2">${row.course_title}</td>
                                        <td class="border p-2">${row.attendance_Status}</td>
                                        <td class="border p-2">${row.date_filed}</td>
                                        <td class="border p-2">${remarksCell}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            tbody.append(`<tr><td colspan="7">No records found</td></tr>`);
                        }
                        
                    }
                }
            )
        }
    );

    $('#clearFilters').on('click',
        function() {
            // reset selects
            $("#formEnrolledCourseTitle").val("");
            $("#formYearLevel").val("");
            $("#formAttendanceStatus").val("");

            var formData = {
                course: $('#formEnrolledCourseTitle').val(),
                year_level: $('#formYearLevel').val(),
                attendance_Status: $('#formAttendanceStatus').val(),
                filterReq: 1
            };

            // reload all records (no filters)
            $.ajax({
                type: "POST",
                url: "../core/handleForms.php",
                data: formData,
                success: function(data) {
                    let tbody = $("#attendanceTable tbody");
                    tbody.empty();
                    data.forEach((row) => {
                        let remarksCell = "";

                        if (!row.remarks || row.remarks.trim() === "") {
                            // if remarks is empty then show form
                            remarksCell = `
                                <form class="viewExcuseLetter">
                                    <input type="hidden" class="letter_StudentName" value="${row.student_username}">
                                    <input type="hidden" class="letter_CourseTitle" value="${row.course_title}">
                                    <input type="hidden" class="letter_DateSubmitted" value="${row.date_filed}">
                                    <button class="px-6 py-2 bg-yellow-500 rounded-full text-lg text-white font-semibold hover:bg-yellow-600">
                                        View Excuse Letter
                                    </button>
                                </form>
                            `;
                        } else {
                            // if remarks has value then just show it
                            remarksCell = row.remarks;
                        }

                        tbody.append(`
                            <tr class="text-center">
                                <td class="border p-2">${row.id}</td>
                                <td class="border p-2">${row.year_level}</td>
                                <td class="border p-2">${row.student_username}</td>
                                <td class="border p-2">${row.course_title}</td>
                                <td class="border p-2">${row.attendance_Status}</td>
                                <td class="border p-2">${row.date_filed}</td>
                                <td class="border p-2">${remarksCell}</td>
                            </tr>
                        `);
                    });
                }
            });
        }
    );

    $('#formAttendanceStatus').on('change',
        function (event) {
            event.preventDefault();

            if ($(this).val() === "Absent") {
                $('#formExcuseLetter').removeClass("hidden").attr("required", "required");
            } else {
                
                $('#formExcuseLetter').addClass("hidden").removeAttr("required").val("");
            }
        }
    );

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
                        $('#letter_id').val(`${data.id}`);
                        $('#letterCourse').append(`<span class="font-bold">Course: ${data.course_title}</span>`);
                        $('#yesno_Letter').append(`
                            <option disabled selected>${data.status}</option>
                            <option value="Approved">Approve</option>
                            <option value="Denied">Deny</option>
                        `);
                        $('#letterBody').append(`${data.letter}`);
                    }
                }
            )
        }
    );

    $("#closeExcuseLetter").on('click',
        function (event) {
            event.preventDefault();
            $("#windowExcuseLetter").addClass("hidden");
            $("#letter_id").val("");
            $("#letterCourse").html("");
            $("#yesno_Letter").html("");
            $("#letterBody").html("");
        }
    );

    $("#yesno_Letter").on("change",
        function (event) {
            event.preventDefault();

            formData = {
                letter_id: $("#letter_id").val(),
                letter_status: $("#yesno_Letter").val(),
                updateLetterStatusReq: 1
            };

            $.ajax(
                {
                    type: "POST",
                    url: "../core/handleForms.php",
                    data: formData,
                    success: function(data) {
                        data = data.trim();
                        switch (data) {
                            case "Success":
                                location.reload();
                                break;
                        
                            default:
                                console.log(JSON.stringify(data));
                                break;
                        }
                    }
                }
            );
        }
    );