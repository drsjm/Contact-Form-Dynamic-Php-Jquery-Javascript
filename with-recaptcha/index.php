<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">

		<title>Dynamic Contact Form By Daniel Rodrigues</title>
		
		<!-- RECAPTCHA -->
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>
	
	<body>
		<div class="container mt-3">
			<h1>Dynamic Contact Form</h1>
			<small>By Daniel Rodrigues</small>
			<form id="form-contact-us">
				<div class="mb-3">
					<label class="form-label">*Name</label>
					<input type="text" class="form-control" id="name" placeholder="Your name" required>
				</div>
				<div class="mb-3">
					<label class="form-label">*E-mail</label>
					<input type="email" class="form-control" id="email" placeholder="Your e-mail" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Phone</label>
					<input type="number" class="form-control" id="phone" placeholder="Your phone number">
				</div>
				<div class="mb-3">
					<label class="form-label">*Message</label>
					<textarea class="form-control" rows="4" id="message" placeholder="Your message..." required></textarea>
				</div>
				<div class="mb-3 form-check">
					<input class="form-check-input" type="checkbox" id="checkbox-terms-1">
					<label class="form-check-label" for="checkbox-terms-1">*I agree with the terms 1.</label>
				</div>
				<div class="mb-3 form-check">
					<input class="form-check-input" type="checkbox" value="" id="checkbox-terms-2">
					<label class="form-check-label" for="checkbox-terms-2">*I agree with the terms 2.</label>
				</div>
        <div class="mb-3">
          <div class="g-recaptcha" data-sitekey="6LfC4aIaAAAAALu4QIYK9yLSPQ8xYdgHZ6bzAeqY"></div><br/>
                                    </div>
				<div id="form-status-messages"></div>
				<div class="mb-3">
					<button type="submit" class="btn btn-secondary">Send Message</button>
				</div>
			</form>
			
	<p>
	  
			<strong>If you want to thank me...</strong>

			<br>

			<a href="https://www.buymeacoffee.com/drsjm" target="_blank">

				<img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: 41px !important;width: 174px !important;box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;" >

			</a>
			
		</p>
		</div>
	
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

		<script>
			$( document ).ready( () => {

				// SUBMIT CONTACT FORM //
				$("#form-contact-us").submit( (e) => {
					e.preventDefault();
				
          let response = grecaptcha.getResponse();
          
          if ( response.length == 0 ) {
            document.getElementById('form-status-messages').innerHTML = '<p style="color: red;">O campo Recaptch é obrigatório!</p>';
            return false;
          }
          if ( response.length > 0 ) {
            
            const name    = $('#name').val();
					  const email   = $('#email').val();
  					const phone   = $('#phone').val();
  					const message = $('#message').val();
  					const terms_1 = document.getElementById('checkbox-terms-1');
  					const terms_2 = document.getElementById('checkbox-terms-2');
  
  					if( name && email && message && terms_1.checked && terms_2.checked ) {
  						let formData = new FormData();
  						formData.append('action', 'Send Email To Business Owner');
  						formData.append('name', name);
  						formData.append('email', email);
  						formData.append('phone', phone);
  						formData.append('message', message);
  						fetch('./send_email_process.php', {
  							method: 'post',
  							cache: 'no-cache',
  							body: formData
  						}).then(function(response) {
  							return response.json();
  						}).then(function(data) {
  							//console.log(data);
  							if (data.status == 'success') {
  							  grecaptcha.reset();
  								document.getElementById("form-contact-us").reset();
  								$("#form-status-messages").html(`<p style="color: green">${data.message}</p>`);
  						    } else if (data.status == 'exists') {
  						    	$("#form-status-messages").html(`<p style="color: red">${data.message}</p>`);
  						    } else if (data.status == 'error') {
  						    	$("#form-status-messages").html(`<p style="color: red">${data.message}</p>`);
  						    } else {
  						        $("#form-status-messages").html(`<p style="color: red">Something went wrong! Please try again...</p>`);
  						    }
  						}).catch(function(error) {
  						    //console.log(error);
  						    $("#form-status-messages").html(`
  						    	<p style="color: red">Ops... something went really wrong. Contact the administrator of the website please.</p>
  						    `);
  						});
  					} else {
  						$("#form-status-messages").html('<p style="color:red;">All fields * are required!');
  					}
  					
          }
          
					return false;
				});
				// SUBMIT CONTACT FORM //

			});
		</script>

	</body>
</html>