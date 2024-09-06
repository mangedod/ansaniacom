<?php 
if(($aksi=="daftar") && (!$_SESSION['userid']))
  	{ $nama_aksi = "Registration";
	  $file = "member.daftar.php"; }
else if($aksi=="login")
  	{ $nama_aksi = "Login";
	  $file = "member.login.php"; }
else if(($aksi=="logout"))
  	{ $nama_aksi = "Logout";
	  $file = "member.logout.php"; }
else if(($aksi=="barcode"))
  	{ $nama_aksi = "Barcode";
	  $file = "member.barcode.php"; } 
else if(($aksi=="updateloc"))
  	{ $nama_aksi = "updateloc";
	  $file = "member.updateloc.php"; } 
else if(($aksi=="poin"))
  	{ $nama_aksi = "poin";
	  $file = "member.poin.php"; } 
else if($aksi=="daftaranggota") 
 	{ $nama_aksi = "Pengiriman Data Pendaftaran";
	  $file = "member.daftaranggota.php"; }
else if($aksi=="registerfb") 
 	{ $nama_aksi = "Pengiriman Data Pendaftaran";
	  $file = "registerfb.php"; }
else if($aksi=="aktifasi") 
 	{ $nama_aksi = "Aktifasi Pendaftaran";
	  $file = "member.aktifasi.php"; }
else if($aksi=="editpost") 
 	{ $nama_aksi = "Perubahan Informasi Suara";
	  $file = "member.editpost.php"; }
else if($aksi=="register")
  	{ $nama_aksi = "Register";
	  $file = "member.register.php"; }
else if($aksi=="login_socmed")
  	{ $nama_aksi = "Login Social Media ";
	  $file = "member.login_socmed.php"; }

//password
else if($aksi=="lupapassword") 
 	{ $nama_aksi = "Bantuan Lupa Password";
	  $file = "member.lupapassword.php"; }
else if($aksi=="usernameerror") 
 	{ $nama_aksi = "Kesalahan Login";
	  $file = "member.salahlogin.php"; }

else if($aksi=="gantipassword") 
 	{ $nama_aksi = "Bantuan Lupa Password";
	  $file = "member.gantipassword.php"; }
else if($aksi=="gantiavatar") 
 	{ $nama_aksi = "Bantuan Lupa Password";
	  $file = "member.gantiavatar.php"; }
	  
else if($aksi=="detailpost") 
 	{ $nama_aksi = "Detail post";
	  $file = "member.detailpost.php";
	   }
else if($aksi=="setting") 
{ 
		$subaksi = $var[4];
		//$tpl->assign("subaksi",$subaksi);
		
		if($subaksi=="gantipassword") 
		{ 
			$nama_aksi = "Ubah Password";
		  	$file = "member.gantipassword.php"; 
		}
		elseif($subaksi=="profile") 
		{ 
			$nama_aksi = "Pengaturan Profile";
		  	$file = "member.setting.profile.php"; 
		}
		elseif($subaksi=="avatar") 
		{ 
			$nama_aksi = "Ganti Avatar";
		  	$file = "member.setting.avatar.php"; 
		}
		elseif($subaksi=="cover") 
		{ 
			$nama_aksi = "Ganti Gambar Sampul Profile";
		  	$file = "member.setting.cover.php"; 
		}
		elseif($subaksi=="privacy") 
		{ 
			$nama_aksi = "Keamanan Privacy";
		  	$file = "member.setting.privacy.php"; 
		}
		elseif($subaksi=="privacydata") 
		{ 
			$nama_aksi = "Keamanan Privacy";
		  	$file = "member.setting.privacydata.php"; 
		}
		elseif($subaksi=="notifikasiemail") 
		{ 
			$nama_aksi = "Notifikasi Email";
		  	$file = "member.setting.notifikasiemail.php"; 
		}
	  	else
		{
			$nama_aksi = "Perubahan Profil";
			$file = "member.setting.php"; 
		}
	}

else if($aksi=="cari-member") 
	{ $nama_aksi = "Cari Member";
	  $file = "cari_member.php";
	  include"cari.php"; }
else if($aksi=="viewme") 
	{ $nama_aksi = "Who View Me?";
	  $file = "member.viewer.php"; } 
else if($aksi=="styleprofile") 
	{ $nama_aksi = "Profile Style";
	  $file = "style.php"; } 
else if($aksi=="setStyle") 
	{ $nama_aksi = "Profile Style";
	  $file = "setStyle.php"; } 
else if($aksi=="search-member") 
	{ $nama_aksi = "Profile Style";
	  $file = "hasilcari.php";
	  include"cari_member.php";
	  include"cari.php";
	   } 
else if($aksi=="syncs") 
	{ $nama_aksi = "Sinkronisasi Social Media";
	  $file = "member.syncs.php"; } 
	  
//update status
else if($aksi=="listpost") $file =  "member.post.php";
else if($aksi=="share") $file =  "member.share.php";
else if($aksi=="addpost") $file = "member.addpost.php";
else if($aksi=="addkomen") $file =  "member.addkomen.php";
else if($aksi=="delkomen") $file =  "member.delkomen.php";
else if($aksi=="delpost") $file =  "member.delpost.php";
else if(($aksi=="like") or ($aksi=="unlike")) $file =  "member.like.php";

//timeline
else if($aksi=="timeline") $file =  "member.timeline.php";
else if($aksi=="detailtimeline") $file =  "member.detailtimeline.php";
else if($aksi=="timelinepost") $file =  "member.timelinepost.php";

else if($aksi=="message") { $file =  "./komponen/message/message.php"; $nama_aksi = "Pesan";}
else if($aksi=="compose") { $file =  "./komponen/message/compose.php"; $nama_aksi = "Kirim Pesan";}
else if($aksi=="send-message") { $file =  "./komponen/message/send-message.php"; $nama_aksi = "Pesan";}
else if($aksi=="detail-message") { $file =  "./komponen/message/detail-message.php"; $nama_aksi = "Pesan";}
else if($aksi=="send-reply") { $file =  "./komponen/message/send-message.php"; $nama_aksi = "Pesan";}
else if($aksi=="delete-message") { $file =  "./komponen/message/delete-message.php"; $nama_aksi = "Pesan";}
else if($aksi=="delete-all") { $file =  "./komponen/message/delete-all.php"; $nama_aksi = "Pesan";}

else if($aksi=="follow") $file =  "./komponen/follow/follow.php";
else if($aksi=="unfollow") $file =  "./komponen/follow/unfollow.php";
else if($aksi=="follower") $file =  "./komponen/follow/followers.php";
else if($aksi=="following") $file =  "./komponen/follow/following.php";
else if($aksi=="search") $file =  "./komponen/member/member.search.php";

else if($aksi=="notifikasi") { $file =  "member.notifikasi.php"; $nama_aksi = "Notifikasi";}
else if($aksi=="notifikasibaru") { $file =  "member.notifikasibaru.php"; $nama_aksi = "Notifikasi";}
else if($aksi=="notifread") { $file =  "member.notifread.php"; $nama_aksi = "Notifikasi";}
else if($aksi=="notifdetail") { $file =  "member.notifdetail.php"; $nama_aksi = "Notifikasi";}
else if($aksi=="rekomendasi") { $file =  "member.rekomendasi.php"; $nama_aksi = "Rekomendasi";}
else if($aksi=="laporanku") { $file =  "member.laporanku.php"; $nama_aksi = "Laporan Saya";}
else if($aksi=="upload") { $file =  "member.upload.php"; $nama_aksi = "Upload Audio";}
else if($aksi=="dashboard") { $file =  "member.dashboard.php"; $nama_aksi = "Dashboard";}
else if($aksi=="myaudio") { $file =  "member.myaudio.php"; $nama_aksi = "Audio Saya";}
	  
//else
else
{ 
	 $nama_aksi = "Dashboard";
	// $file = "member.dashboard.php";
}

if(!empty($file)) include($file);

?>