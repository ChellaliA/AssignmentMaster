
console.log("Ajax.js loaded successfully!");
var Base_Url = 'http://localhost/jobby';


function ShowJobEditForm(job_id) {
  $.ajax({
    url: Base_Url + '/user/jobs/' + job_id + '/edit',
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      
      // Populate the form fields with the returned data
      var formAction = $('#editForm').attr('action');
      formAction = formAction.replace('{ID}', response.job.id);
      $('#editForm').attr('action', formAction);


      $('#titre').val(response.job.titre);

      $('#categorie').empty(); // clear existing options
      $.each(response.categories, function (key, value) {
        $('#categorie').append('<option value="' + value.categorie_id + '">' + value.categorie_nom + '</option>');
      });
      $('#categorie').val(response.job.categorie_id);

      $('#ville').empty(); // clear existing options
      $.each(response.villes, function (key, value) {
        $('#ville').append('<option value="' + value.ville_id + '">' + value.ville_nom + '</option>');
      });


      $('#ville').val(response.job.ville_id);

      $('#date').val(response.job.date_de_travail);
      $('#nbr_postes').val(response.job.nbr_postes);
      $('#prix').val(response.job.prix);
      $('#tarification').val(response.job.tarification);
      
      $('#description').val(response.job.description);
      // Show the edit modal
      $('#editModal').modal('show');
    },
    error: function (xhr, textStatus, errorThrown) {
      console.log('Error retrieving job details');
    }
  });
}


function submitForm(form,message) {
  // Get the form data as an object
  var formData = new FormData(form);
  // Send an AJAX request
  $.ajax({
    url: form.action,
    type: form.method,
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response.error) {
        alert(response.error);
      } else {
      console.log(message);
      alert(message);
      location.reload();
    }
    },
    error: function (xhr, status, error) {
      alert(error);
      window.location.assign('/jobby/public');
      console.error( error);
    }
  });
}


function ShowApplicationDeatils(id) {
  $.ajax({
    url: Base_Url + '/user/job/applications/' + id,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      // Populate the form fields with the returned data
      alert(JSON.stringify(response));
      $('#ApplicantName').text('Name: ' + response.application.candidat_nom + ' ' + response.application.candidat_prenom);
      $('#ApplicantRating').text('Rating: ' + response.application.candidat_note + '/5');
      $('#ApplicantJobsDone').text('Jobs Done: ' + response.application.jobs_done);
      $('#ApplicationDate').text('Application Date: ' + response.application.date_de_candidature);
      $('#ApplicantPhone').text('Phone: ' + response.application.candidat_telephone);
      $('#ApplicantEmail').text('Email: ' + response.application.candidat_email);
      $('#ApplicantPrice').text('Preferred Price: ' + response.application.salaire_souhaite + '$/hr');
      $('#ApplicantSkills').text('Skills: ' + response.application.competence_names);
      $('#ApplicantMessage').text(response.application.message);
      // Set the job ID in the modal form action
      $('#responseForm').attr('action', Base_Url + '/user/job/applications/' + response.application.job_id + '/response');

      // Show the modal
      $('#applicantDetailsModal').modal('show');

      $('#applicantDetailsModal').modal('show');

    },
    error: function (xhr, textStatus, errorThrown) {
      console.log('Error retrieving aplication details');
    }
  });
}