<footer id="footer"><?php echo $text_footer; ?><br /><?php echo $text_version; ?></footer></div>
<script type="text/javascript"><!--
function codeViewBusPro() {
	summernote = $('.summernote');
	if ($(summernote).css('display') == 'none') {
		summernote.show().css('height', 300);
		$('.btn-codeview-bus').addClass('active');
	} else {
		summernote.hide();
		$('.btn-codeview-bus').removeClass('active');
	}
}

$(document).ready(function() {
	if ($('.summernote').length) {
		$('.btn-codeview').after('<button type="button" onclick="codeViewBusPro();" class="note-btn btn btn-warning btn-sm btn-codeview-bus" title="" data-original-title="Code View Bus"><i class="note-icon-code"></i></button>');

		jopa = document.getElementsByClassName('note-editable');

		for (i=0; i<jopa.length; i++) {
			if (jopa[i].innerHTML == '<p><br></p>') {
				jopa[i].innerHTML = '';
			}
		}
	}
});
//--></script>
</body></html>
