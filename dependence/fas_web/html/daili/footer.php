<script>

	
  function delDLine(id){
		var url = './qq_admin_daili.php?act=del&id='+id;
		$.post(url,{
		  
		},function(){
			
		});
		$('.line-id-'+id).slideUp();
  }
  function delLine(id){
		var url = './user_list.php?my=del&user='+id;
		$.post(url,{
		  
		},function(){
			
		});
		$('.line-id-'+id).slideUp();
  }
  

  
  function addLl(id,n){
		var url = './option.php?my=addll&user='+id;
		$.post(url,{
			"n":n,
			"user":id
		  },function(){
			
		});
		var m = $('.line-id-'+id+" .maxll");
		var ne = n*1024;
		m.html(ne);
  }

  function outline_udp(id){
		var url = './option.php?my=outline_udp&user='+id;
		$.post(url,{
			"user":id
		  },function(){
			
		});
		$('.line-id-'+id).slideUp();
  }
  
 
  </script>
  				</div>
  			</div>
 	
 </div> <!--table-->

</body>
</html>
