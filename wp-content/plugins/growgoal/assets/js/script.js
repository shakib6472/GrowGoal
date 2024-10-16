
jQuery(document).ready(function ($) {
  console.log("initiate 1");

  // Set the date we're counting down to
  var countDownDate = new Date().getTime() + 5 * 24 * 60 * 60 * 1000;

  // Update the count down every 1 second
  var x = setInterval(function () {
    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the respective elements
    $("#days").text(days);
    $("#hours").text(hours);
    $("#minutes").text(minutes);
    $("#seconds").text(seconds);

    // If the count down is finished, write some text
    if (distance < 0) {
      clearInterval(x);
      $("#countdown").html("EXPIRED");
    }
  }, 1000);


  function updateDateTime() {
    // Create a new Date object
    var now = new Date();

    // Format the time (AM/PM format)
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes; // Add leading zero to minutes
    seconds = seconds < 10 ? '0' + seconds : seconds; // Add leading zero to minutes
    var timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

    // Format the date (e.g., Monday, 3rd October, 2022)
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    var dayName = days[now.getDay()];
    var day = now.getDate();
    var monthName = months[now.getMonth()];
    var year = now.getFullYear();

    // Format the day suffix (st, nd, rd, th)
    var daySuffix = function (d) {
      if (d > 3 && d < 21) return 'th';
      switch (d % 10) {
        case 1: return "st";
        case 2: return "nd";
        case 3: return "rd";
        default: return "th";
      }
    };

    var dateString = dayName + ', ' + day + daySuffix(day) + ' ' + monthName + ', ' + year;

    // Update the HTML elements
    $('.custom-sec-current-time').text(timeString);
    $('.custom-sec-current-date').text(dateString);
  }

  // Update the time and date initially
  updateDateTime();

  // Update the time and date every 60 seconds (60000 milliseconds)
  setInterval(updateDateTime, 1000); // Adjust the interval to your preference

  //flatpickr
  $(".date-pick-for-time").flatpickr({
    enableTime: false,
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    minDate: new Date().fp_incr(1),
    maxDate: new Date().fp_incr(7), // 14 days from now
  });

  //SHow dates

  $(".dates-visible-toggle").click(function (e) {
    e.preventDefault();
    var thisParent = $(this).parent();
    thisParent.find(".dates").css("visibility", function (i, visibility) {
      return visibility === "visible" ? "hidden" : "visible";
    });
  });

  //Time Picked
  $(".date-picked").click(function (e) {
    e.preventDefault();
    var thisParent = $(this).parent().parent().parent().parent();
    thisParent.find(".loading").css("display", "flex");
    thisParent.find(".time-maps").empty(); // Clear existing time slots
    var datadate = $(this).data("date");
    var date = $(this).text();
    var teacherid = $(this).data("teacher");
    thisParent.find(".dates-visible-toggle p").text(date);
    thisParent.find(".dates").css("visibility", function (i, visibility) {
      return visibility === "visible" ? "hidden" : "visible";
    });

    //getting available slots

    $.ajax({
      type: "POST",
      url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
      data: {
        action: "get_all_available_slots_for_this_day", // Action hook to handle the AJAX request in your functions.php
        date: date, // Pass form data to the backend
        datadate: datadate, // Pass form data to the backend
        teacherid: teacherid, // Pass form data to the backend
      },
      dataType: "json",
      success: function (response) {
        // Handle success response
        var timeslots = response;
        //Do for each time slot creat an element <div class="time-slot time-picked" data-time="09:00 AM"> 09:00 AM</div> & insert all elemetns in .time-maps div
        thisParent.find(".time-maps").empty(); // Clear existing time slots
        timeslots.forEach(function (slot) {
          var timeSlotElement = $("<div></div>")
            .addClass("time-slot time-picked")
            .attr("data-time", slot)
            .text(slot);
          thisParent.find(".time-maps").append(timeSlotElement);
          $(".loading").css("display", "none");
        });

        // Reload the window
        //location.reload();
      },
      error: function (xhr, textStatus, errorThrown) {
        // Handle error
        console.error("Error:", errorThrown);
      },
    });
  });

  // $(".time-picked").click(function (e) {
  //   e.preventDefault();
  //   var mainContainer = $(this).closest(".teacher"); // Find the closest ancestor with class 'teacher'
  //   var teacherName = mainContainer.find(".name").text(); // Get the text of the element with class 'name' within 'mainContainer'
  //   console.log(teacherName); // Log the teacher's name to the console
  // });

  $(document).on("click", ".time-picked", function (e) {
    e.preventDefault();

    //Ajax verify
    $(".pre-loading").css("display", "flex");
    var mainContainer = $(this).closest(".teacher");

    $.ajax({
      type: "POST",
      url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
      data: {
        action: "check_available_class_for_students", // Action hook to handle the AJAX request in your functions.php
      },
      dataType: "json",
      success: function (response) {
        // Handle success response
        console.log(response);
        // Reload the window

        if (response > 0) {
          $(".teacher-id").text(mainContainer.find(".teacherid").text());
          console.log(mainContainer.find(".teacherid").text());
          $(".teacher-name").text(mainContainer.find(".name").text());
          $(".booked-date").text(mainContainer.find(".placing").text());
          $(".booked-time").text($(this).text());
          $(".lesson-name").text("5");
          //show the popup
          $(".confirmation-popup").show();
          $(".pre-loading").css("display", "none");
        } else {
          $(".pre-loading").css("display", "none");
          $(".cancellation-popup").show();
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        // Handle error
        console.error("Error:", errorThrown);
      },
    });
  });

  $(".cencelled-booking").click(function (e) {
    e.preventDefault();
    $(".confirmation-popup").hide();
  });

  $(".close-popup").click(function (e) {
    e.preventDefault();
    $(".cancellation-popup").hide();
  });

  $(".confirm-booking").click(function (e) {
    e.preventDefault();
    console.log("Confirm Booking Fired");
    //$(".confirmation-popup").hide();
    $(".pre-loading.second").show();
    $(".pre-loading.second .loading").show();

    var teacherId = $(".teacher-id").text();
    var bookedDate = $(".booked-date").text();
    var bookedTime = $(".booked-time").text();
    var lessonName = $(".lesson-name").text();
    var lessonName = $(".lesson-name").text();
    var lessontype = $(".group-single .item.active label").text();

    console.log("Confirm Booking Ajax Firing");
    $.ajax({
      type: "POST",
      url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
      data: {
        action: "add_new_booking_from_student", // Action hook to handle the AJAX request in your functions.php
        teacherId: teacherId, // Pass form data to the backend
        bookedDate: bookedDate, // Pass form data to the backend
        bookedTime: bookedTime, // Pass form data to the backend
        lessonName: lessonName, // Pass form data to the backend
        lessontype: lessontype, // Pass form data to the backend
      },
      dataType: "json",
      success: function (response) {
        // Handle success response
        console.log(response);
        $(".pre-loading.second").hide();
        // Reload the window
        window.location.href = ajax_object.home_url + "/dashboad/lessons";
        //location.reload();
      },
      error: function (xhr, textStatus, errorThrown) {
        // Handle error
        console.error("Error:", errorThrown);
      },
    });
  });

  //Group Single
  $(".group-single .item").click(function (e) {
    e.preventDefault();
    $(this).find("input[name=type]").attr("checked", true);
    $(".group-single .item").removeClass("active");
    $(this).addClass("active");
  });

  /* ====================================================
//Send Message
======================================================= */
  $(".message-send-button-teacher").click(function (e) {
    e.preventDefault();
    $(".pre-loading").css("display", "flex");
    var studentid = $("#student-select-box").val();
    var message = $("#message-box").val();

    if (studentid) {
      if (message) {
        $(".error .error").text("");

        // Send Message
        $.ajax({
          type: "POST",
          url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
          data: {
            action: "send_message_student", // Action hook to handle the AJAX request in PHP
            studentid: studentid, // Pass form data to the backend
            message: message, // Pass form data to the backend
          },
          dataType: "json",
          success: function (response) {
            // Handle success response
            console.log(response);
            if (response.success) {
              alert("Message sent successfully");
              // location.reload(); // Reload the window after successful submission
            } else {
              alert("Failed to send message: " + response.data);
            }
          },
          error: function (xhr, textStatus, errorThrown) {
            // Handle error
            console.error("Error:", errorThrown);
            alert("An error occurred while sending the message.");
          },
        });
      } else {
        $(".pre-loading").css("display", "none");
        $(".error .error").show(300).text("Please Enter Your Message First");
      }
    } else {
      $(".pre-loading").css("display", "none");
      $(".error .error").show(300).text("Please Select Student First");
    }
  });

  /*=======================================================================
  //reply Message
  =======================================================================*/

  // Handle form submission
  $(".reply_message").click(function (e) {
    e.preventDefault(); // Prevent the default form submission
    $(".pre-loading").css("display", "flex");
    // Collect form data
    var replyMessage = $("#reply-message").val();
    var receiverId = $(this).data("receiver-id"); // Pass receiver ID from the form data
    if (replyMessage) {
      // Perform AJAX request
      $.ajax({
        type: "POST",
        url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
        data: {
          action: "send_reply_message", // Action hook to handle the AJAX request
          receiver_id: receiverId,
          message: replyMessage,
        },
        success: function (response) {
          if (response.success) {
            location.reload(); // Reload the page to show the new message
          } else {
            alert("Failed to send reply.");
            $(".pre-loading").css("display", "none");
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          console.error("AJAX Error:", textStatus, errorThrown);
        },
      });
    }
  });

  /* ====================================================
//Convert to Select2
======================================================= */
  $("#student-select-box").select2();

  /* ====================================================
// Upload Profile Picture
======================================================= */
  // Trigger file input click when the button is clicked
  $('.custom-add-photo').on('click', function () {
    $('#profile_upload').click();
  });

  // Handle file input change, display preview, and auto-upload
  $('#profile_upload').on('change', function () {
    var file_data = $('#profile_upload').prop('files')[0];
    var form_data = new FormData();
    form_data.append('profile_upload', file_data);
    form_data.append('action', 'upload_user_profile_picture'); // Action for AJAX

    // Display the image preview
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.custom-profile-photo').attr('src', e.target.result); // Display the image
    }
    reader.readAsDataURL(file_data); // Convert the image to base64

    // AJAX call to upload the file
    $.ajax({
      url: ajax_object.ajax_url, // WordPress AJAX URL
      type: 'POST',
      data: form_data,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        alert('Profile picture uploaded successfully!');
        // Optionally handle further actions after upload
      },
      error: function (xhr, status, error) {
        alert('An error occurred: ' + error);
      }
    });
  });


  $('#custom-sub-btn').click(function (e) {
    e.preventDefault();
    var note = $('#profile_note').val();
    var form_data = new FormData();
    form_data.append('note', note);
    form_data.append('action', 'daily_note_update'); // Action for AJAX
    // AJAX call to upload the file
    $.ajax({
      url: ajax_object.ajax_url, // WordPress AJAX URL
      type: 'POST',
      data: form_data,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        alert('Daily Note Updated successfully!');
        // Optionally handle further actions after upload
      },
      error: function (xhr, status, error) {
        alert('An error occurred: ' + error);
      }
    });
  });

  $('.zoom-not-seted').click(function (e) {
    e.preventDefault();
    alert('Zoom is not set yet, Please contact with Your Teacher to set the zoom url.')
  });

  $('.video_popup').click(function (e) {
    e.preventDefault();
    $('.video_pop_record_holder').show(500);
  });
  $('.video_pop_record_holder').click(function (e) {
    e.preventDefault();
    $(this).hide(500);
  });
  $('.video_pop_record_holder div').click(function (e) {
    e.preventDefault();
  });
  $('.zoom_url').click(function (e) {
    if ($('#status-message').text() != 'Waiting Time Finished') {
      e.preventDefault();
      alert('This is not the right time to join. Please wait until time finish');
    }
  });

  $('.custom-sec-right-lesson.desabled').click(function (e) {
    e.preventDefault();
    alert('No Practice File Added Here');
  });


  $('.sent_message').click(function (e) {
    var messageText = $('#message').val();
    var teacher = $('.t-radio:checked').val();

    if (messageText) {
      if (teacher) {
        $.ajax({
          type: "POST",
          url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
          data: {
            action: "send_reply_message", // Action hook to handle the AJAX request
            receiver_id: teacher,
            message: messageText,
          },
          success: function (response) {
            if (response.success) {
              alert('Message Sent Successfuly');

            } else {
              alert("Failed to send reply."); 
            }
          },
          error: function (xhr, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
          },
        });


      } else {
        alert('Please select a teacher first to send message');
      }
    } else {
      alert('Please enter message first to send message');
    }
  });
  //Jquery End
});
