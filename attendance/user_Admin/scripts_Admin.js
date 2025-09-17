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
    )

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
                                tbody.append(`
                                    <tr class="text-center">
                                        <td class="border p-2">${row.id}</td>
                                        <td class="border p-2">${row.year_level}</td>
                                        <td class="border p-2">${row.student_username}</td>
                                        <td class="border p-2">${row.course_title}</td>
                                        <td class="border p-2">${row.attendance_Status}</td>
                                        <td class="border p-2">${row.date_filed}</td>
                                        <td class="border p-2">${row.remarks}</td>
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
    )

    $("#clearFilters").on("click",
        function() {
            // reset selects
            $("#formEnrolledCourseTitle").val("");
            $("#formYearLevel").val("");
            $("#formAttendanceStatus").val("");

            // reload all records (no filters)
            $.ajax({
                type: "POST",
                url: "../core/handleForms.php",
                data: { filterReq: 1 }, // no filters sent
                dataType: "json",
                success: function(data) {
                    let tbody = $("#attendanceTable tbody");
                    tbody.empty();
                    data.forEach((row) => {
                        tbody.append(`
                            <tr class="text-center">
                                <td class="border p-2">${row.id}</td>
                                <td class="border p-2">${row.year_level}</td>
                                <td class="border p-2">${row.student_username}</td>
                                <td class="border p-2">${row.course_title}</td>
                                <td class="border p-2">${row.attendance_Status}</td>
                                <td class="border p-2">${row.date_filed}</td>
                                <td class="border p-2">${row.remarks}</td>
                            </tr>
                        `);
                    });
                }
            });
        }
    );