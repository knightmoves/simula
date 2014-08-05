	<script>
			function epakita() {
				var button_block = dojo.byId("button_block");
				require(["dojo/_base/fx"], function(fx){
				  fx.animateProperty({
				  node:"content_comment",
				  properties: {
					  height: { end: 250, start:85 }
				  }
				 }).play();
				});	
				require(["dojo/dom-style"], function(domStyle){
				  domStyle.set("button_block", "display", "inline");
				});
				
			}
			function ebalik() {
				require(["dojo/_base/fx"], function(fx){
				  fx.animateProperty({
				  node:"content_comment",
				  properties: {
					  height: { end: 85, start:250 }
				  }
				 }).play();
				 
				});			
				require(["dojo/dom-style"], function(domStyle){
				  domStyle.set("button_block", "display", "none");
				});
			}
			dojo.ready(function(){
				dojo.connect(dojo.byId("content_comment"),"focus",epakita);
				dojo.connect(dojo.byId("cancel"),"click",ebalik);
			});
		</script>

<div style="  margin: 50px 50px 50px 306px; padding:10px; font-family:Arial, Helvetica, sans-serif; background-color:#f2f2f2; width:460px; !important">
<b>Focus on this text box</b><br />
<textarea style="" id="content_comment" placeholder="What's on your mind?"></textarea>
<div id="button_block">
<input type="submit" id="button" value=" Share "/><input type="submit" id='cancel' value=" Cancel"  />
</div>

</div>
