<?php
include "../../lib/FunctionClass2.php";
$dataClassOnOff = dataClassOnOff('Chưa mở', $connection);
session_start();

$maHS = $_SESSION['MaHS'];

$check = false;
if (isset($_SESSION['MaHS'])) {
  $check = true;
}
$tenHS = selecttenHS($connection, $maHS['MaHS']);
$detailStudent = selectStudent($connection, $maHS['MaHS']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['btn-logout'])) {

    session_start();
    session_unset();
    session_destroy();
    header("Location: ../home/home.php");
  }
}

$jstenHS = json_encode($tenHS);
$jsdetailStudent = json_encode($detailStudent);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="path-to-the-file/splide.min.css"> -->
  <!-- bootstrap.css-->
  <link rel="stylesheet" href="../../plugins/bootstrap-5.2.3-dist/css/bootstrap.min.css" />
  <!--slick.css-->
  <link rel="stylesheet" href="../../plugins/slick-1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="../../assets/css/home.css" />
  <!--Animated css-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="../../assets/css/common.css">
  <style>
    .listClassOn1 {
      background-color: #7ebbe7;
      color: #fff;
      font-weight: bold;
      padding: 5px 25px;
    }

    .listClassOn2 {
      background-color: #ffd95c;
      color: #fff;
      font-weight: bold;
      padding: 5px 25px;
    }

    .introNavImg a {
      text-decoration: none;
      color: #fff;
    }
    .menubar-nav:hover {
      background-color: turquoise;
    }
  </style>

  <title>Home Student</title>
</head>

<body>
  <div class="PageWrap">
    <div id="menu-bar">

    </div>
    <div class="PageHomeInner">
      <div class="PageHomeIntroWrap">
        <div class="PageHomeIntroBGDeco"></div>
        <div class="PageHomeIntroBGDeco"></div>
        <div class="PageHomeIntroBGDeco"></div>
        <div class="PageHomeIntroHeader">HÀNG TRIỆU PHỤ HUYNH ĐÃ LỰA CHỌN LODUHI ENGLISH
          <br />
          ĐỂ CON HỌC CÙNG NIỀM CẢM HỨNG
        </div>
        <div class="PageHomeIntroSlide">
          <section class="IntroSlider">
            <div class="slider-quote">
              <img class="silder-quote-img" src="../../assets/images/quote.svg" />
            </div>
            <div class="slider-for introSlider">
              <div class="introSlidler-item">Mình tên là Nguyễn Mai Chi. Với kết quả 147 điểm Cambridge, mình đã vinh dự nhận được Học bổng 50% từ Đại học British University Vietnam trong Lễ Vinh danh Cambridge của LoDuHi. Mình muốn cảm ơn thầy Wade đã luôn truyền cảm hứng và giúp đỡ mình rất nhiều để đạt được thành tích này! Cảm ơn LoDuHi đã cho mình một môi trường học tập hết ý! </div>
              <div class="introSlidler-item">Tớ tên là Nguyễn Đức Hạnh Nguyên. Tớ đã học tại LoDuHi English được một năm rồi. Tớ thực sự thích LoDuHi vì ở đây tớ làm quen nhiều người bạn mới. Tớ cũng rất thích các buổi hội thảo của thầy James nữa. Thầy đã giúp tớ tự tin hơn nhiều khi nói tiếng Anh. Giờ ngày nào tớ cũng muốn nói tiếng Anh thôi! </div>
              <div class="introSlidler-item">Xin chào! Tớ là Nguyễn Khang Thịnh và ước mơ của tớ là trở thành một nhà sáng chế nổi tiếng! Tớ thích chế tạo mọi thứ và khi tớ lớn lên, tớ muốn đi du lịch khắp thế giới để khoe những phát minh của mình. Tiếng Anh sẽ rất quan trọng khi tớ giao tiếp, đó là lý do tại sao tớ thích học tại LoDuHi. Sau mỗi tiết học, tớ cảm thấy mình tiến gần hơn đến ước mơ của mình! </div>
              <div class="introSlidler-item">Tớ tên là Đỗ Hồng Quân. Tớ đã học tại LoDuHi hơn một năm. Tớ thích ở LoDuHi vì thầy của tớ - thầy Kieran thực sự tốt bụng và vui tính! Tớ thích những bài giảng của thầy về những địa điểm và các loài vật tuyệt vời trên khắp thế giới. Quả là thú vị khi học về những điều mới bằng tiếng Anh. </div>
              <div class="introSlidler-item">Tớ tên là Trường An và tớ rất thích Chương trình Hè tại LoDuHi. Tớ được nói tiếng Anh mỗi ngày trong 6 tuần. Tớ nghĩ rằng kỹ năng tiếng Anh và sự tự tin của tớ đã cải thiện rất nhiều. Các thầy cô có những bài giảng và hoạt động siêu thú vị. Chúng tớ cũng đã tới Nông trại Hoa Lúa. Đó là ngày mùa hè yêu thích của tớ. Tớ hy vọng rằng mình có thể tham gia lần nữa vào mùa hè năm sau!</div>
              <div class="introSlidler-item">Xin chào. Tớ tên là Võ Hà My và tớ 6 tuổi. Cô giáo của tớ là cô Eleanor. Cô rất thân thiện và vui vẻ. Tớ thích nói tiếng Anh. Tớ thích hát những bài hát tiếng Anh và chơi những trò chơi cùng bạn bè! </div>
            </div>
            <button class="carousel-control-prev intro-control-prev" type="button" data-bs-target=".slider-for" data-bs-slide="prev">
              <span class="carousel-control-prev-icon intro-control-next intro-control-icon-prev" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next intro-control-next-wrap" type="button" data-bs-target=".slider-for" data-bs-slide="next">
              <span class="carousel-control-next-icon  intro-control-icon-next" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
            <div class="introSlidePagging">
              <div class="slider-nav introNavigation">
                <div class="introNav-item">
                  <div class="intro-item-wrap">

                    <img src="../../assets/images/stud1.png" alt="" class="introNavImg">
                  </div>
                  <div class="intro-item-name">Nguyễn Mai Chi</div>
                </div>
                <div class="introNav-item">
                  <div class="intro-item-wrap">

                    <img src="../../assets/images/stud2.png" alt="" class="introNavImg">
                  </div>
                  <div class="intro-item-name">Nguyễn Đức Hạnh Nguyên</div>
                </div>
                <div class="introNav-item">
                  <div class="intro-item-wrap">

                    <img src="../../assets/images/stud3.png" alt="" class="introNavImg">
                  </div>
                  <div class="intro-item-name">Nguyễn Khang Thịnh</div>

                </div>
                <div class="introNav-item">
                  <div class="intro-item-wrap">

                    <img src="../../assets/images/stud4.png" alt="" class="introNavImg">
                  </div>
                  <div class="intro-item-name"> Đỗ Hồng Quân</div>

                </div>
                <div class="introNav-item">
                  <div class="intro-item-wrap">

                    <img src="../../assets/images/stud5.png" alt="" class="introNavImg">
                  </div>
                  <div class="intro-item-name">Trường An</div>

                </div>
                <div class="introNav-item">
                  <div class="intro-item-wrap">

                    <img src="../../assets/images/stud6.png" alt="" class="introNavImg">
                  </div>
                  <div class="intro-item-name">Võ Hà My</div>

                </div>
              </div>
            </div>
          </section>

        </div>
        <div class="wave-jouney-start-wrap ">
          <img class="wave-start-jouney img-inner" src="../../assets/images/wave-jouney.svg" />
        </div>
        <div class="PageHomeIntroJouney page-wrap-flex">
          <div class="page-inner-1170 page-wrap-flex">
            <div class="PageHomeIntroJouneyTitle">HÀNH TRÌNH 30 NĂM NUÔI DƯỠNG SỰ TỰ TIN CỦA <br /> HÀNG TRIỆU TRẺ EM VIỆT!</div>
          </div>
          <div class="jouney-intro-wrap page-inner-1170">

            <ul class="nav nav-tabs intro-jouney-ul" id="intro-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="jouney1" data-bs-toggle="tab" data-bs-target="#jouney-1" type="button" role="tab" aria-controls="jouney-1" aria-selected="true">Tổng quan</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney2" data-bs-toggle="tab" data-bs-target="#jouney-2" type="button" role="tab" aria-controls="jouney-2" aria-selected="false">1995</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney3" data-bs-toggle="tab" data-bs-target="#jouney-3" type="button" role="tab" aria-controls="jouney-3" aria-selected="false">1996</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney4" data-bs-toggle="tab" data-bs-target="#jouney-4" type="button" role="tab" aria-controls="jouney-4" aria-selected="true">2002</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney5" data-bs-toggle="tab" data-bs-target="#jouney-5" type="button" role="tab" aria-controls="jouney-5" aria-selected="false">2003</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney6" data-bs-toggle="tab" data-bs-target="#jouney-6" type="button" role="tab" aria-controls="jouney-6" aria-selected="false">2006</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney7" data-bs-toggle="tab" data-bs-target="#jouney-7" type="button" role="tab" aria-controls="jouney-7" aria-selected="true">2007</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney8" data-bs-toggle="tab" data-bs-target="#jouney-8" type="button" role="tab" aria-controls="jouney-8" aria-selected="false">2012</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="jouney9" data-bs-toggle="tab" data-bs-target="#jouney-9" type="button" role="tab" aria-controls="jouney-9" aria-selected="false">2022</button>
              </li>
            </ul>
          </div>
          <div class="tab-content" id="intro-tab-content">
            <div class="tab-pane fade show active" id="jouney-1" role="tabpanel" aria-labelledby="jouney1">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap">
                  <div class="img-bg">
                    <img src="../../assets/images/tongquan-jouney.png" alt="" class="jou-img" />
                  </div>
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">Chào mừng bạn đến với LoDuHi English!</div>
                  <div class="jou-right-content">Chào mừng bạn đến với LoDuHi English - “Where the best become better” - nơi các học viên được khơi sáng tình yêu học tập để tự tin sử dụng tiếng Anh như ngôn ngữ thứ hai, làm chủ kỹ năng tương lai và khai phóng tiềm năng của bản thân trước thế giới không ngừng biến đổi.

                    <br />Trong suốt gần 30 năm mang tiếng Anh gần hơn với cuộc sống, LoDuHi tự hào và cảm thấy biết ơn khi được chứng kiến các thế hệ học viên của mình trưởng thành, và thành công. Chắc chắn chúng tôi sẽ nỗ lực hơn nữa để mang đến những trải nghiệm học tập tuyệt vời!
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-2" role="tabpanel" aria-labelledby="jouney2">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/1995.svg" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">
                    Thành lập</div>
                  <div class="jou-right-content">Trung tâm tiếng Anh LoDuHi đầu tiên được thành lập bởi 2 nhà sáng lập Khalid Muhmood & Arabella Peters với sự chứng kiến của đại diện Hoàng Gia Anh và Bộ Giáo dục & Đào tạo Việt Nam.</div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-3" role="tabpanel" aria-labelledby="jouney3">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/1996.svg" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">Áp dụng chuẩn Cambridge</div>
                  <div class="jou-right-content">LoDuHi đã trở thành 1 trong những tổ chức đầu tiên được ủy quyền chính thức bởi viện khảo thí Cambridge. Cũng trong năm này LoDuHi trở thành đối tác chiến lược của Đài truyền hình Việt Nam với vai trò cố vấn cho những chương trình giáo dục danh tiếng như: Đường lên đỉnh Olympia, Rung chuông vàng...
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-4" role="tabpanel" aria-labelledby="jouney4">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/1997.png" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">Người thầy chuẩn quốc tế</div>
                  <div class="jou-right-content">LoDuHi chính thức trở thành thành viên duy nhất tại Việt Nam của tổ chức giảng dạy lâu đời nhất thế giới - International House (IH).</div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-5" role="tabpanel" aria-labelledby="jouney5">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/2001.png" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">Giáo trình chuẩn quốc tế</div>
                  <div class="jou-right-content">LoDuHi là tổ chức đầu tiên kết hợp với nhà xuất bản Oxford University Press ra mắt giáo trình Get- Set - Go. Đây cũng chính là bộ giáo trình chuẩn quốc tế mà 2 năm sau đó cho tới hiện nay vẫn đang được công nhận và sử dụng rộng rãi trong hệ thống giáo dục Việt Nam.

                    <br />Tiếp nối thành công của Get-Set-Go, LoDuHi đã nhiều lần cải tiến giáo trình học tập trong những năm sau đó. Điển hình là hệ thống đào tạo công dân toàn cầu AGLS đã được ra mắt vào 2017 với sự hợp tác chiến lược cùng nhà xuất bản hàng đầu thế giới National Geographic Learning.
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-6" role="tabpanel" aria-labelledby="jouney6">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/2006.svg" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">Thành viên Hoàng gia</div>
                  <div class="jou-right-content">Với những đóng góp của mình cho nền giáo dục Việt Nam, nhà sáng lập LoDuHi English – ông Khalid Muhmood được Bộ Giáo dục và Đào tạo trao tặng huân chương “Vì sự nghiệp giáo dục" (2006). Đồng thời được nữ hoàng Anh phong tước ‘Thành viên Hoàng Gia’ (2008).</div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-7" role="tabpanel" aria-labelledby="jouney7">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/2007.svg" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">Giải thưởng quốc tế</div>
                  <div class="jou-right-content">LoDuHi được vinh danh “Tổ chức đào tạo Anh ngữ của năm” tại Education Investor Asia Awards với vai trò tiên phong mang đến trẻ em Việt Nam chương trình đào tạo công dân toàn cầu.</div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-8" role="tabpanel" aria-labelledby="jouney8">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/2002.svg" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">
                    Ứng dụng công nghệ</div>
                  <div class="jou-right-content">Tạm biệt toàn bộ phương thức học truyền thống với bảng đen, đĩa CD để trở thành đơn vị đầu tiên đưa Internet, bảng tương tác IWB vào lớp học.</div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="jouney-9" role="tabpanel" aria-labelledby="jouney9">
              <div class="jouney-tab-content-wrap">
                <div class="left-img-wrap border-top-img">
                  <img src="../../assets/images/2021-ocqsEMJdplsfmm71.jpg" alt="" class="jou-img " />
                </div>
                <div class="right-content-wrap">
                  <div class="jou-right-title">60+ trung tâm trên toàn quốc</div>
                  <div class="jou-right-content">Cán mốc 60 trung tâm toàn quốc và nhận Giải thưởng Deloitte, Best Managed Company cùng Giải thưởng APEA - Thương hiệu truyền cảm hứng.</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="background-line">
          <div class="bg-line animated go bg-animation-line">
            <img class="desktop-line img-inner" src="../../assets/images/i-line.svg" alt="">
            <!-- <img class="mb-line" src="/LoDuHi/images/vision/i-line-mb.svg" alt="line"> -->
          </div>
          <div class="i-rocket animated go">
            <img src="../../assets/images/i-rocket.svg" alt="">
          </div>
        </div>
        <div class="vision-wrap">
          <div class="PageVision">
            <div class="pageVision-left-wrap">

              <div class="pageVision-item">
                <button class=" vision-btn vision-active" type="button" data-bs-toggle="collapse" data-bs-target="#vision-item-1" aria-expanded="false" aria-controls="vision-item-1">
                  TẦM NHÌN
                </button>
                <div class="collapse show" id="vision-item-1">
                  <div class="vision-content">
                    Nuôi dưỡng thế hệ trẻ tự tin đầy tiềm năng trước thế giới không ngừng biến đổi
                  </div>
                </div>
              </div>
              <div class="pageVision-item">
                <button class=" vision-btn" type="button" data-bs-toggle="collapse" data-bs-target="#vision-item-2" aria-expanded="false" aria-controls="vision-item-2">
                  SỨ MỆNH
                </button>
                <div class="collapse" id="vision-item-2">
                  <div class="vision-content">
                    Mang tiếng Anh vào gần hơn với cuộc sống thông qua các bài học thực tiễn, có tính ứng dụng và khuyến khích các con tìm hiểu về thế giới quanh mình
                  </div>
                </div>
              </div>
              <div class="pageVision-item">
                <button class=" vision-btn" type="button" data-bs-toggle="collapse" data-bs-target="#vision-item-3" aria-expanded="false" aria-controls="vision-item-3">
                  GIÁ TRỊ
                </button>
                <div class="collapse" id="vision-item-3">
                  <div class="vision-content">
                    Đam mê<br />
                    Trách nhiệm<br />
                    Đổi mới<br />
                    Đồng hành<br />
                    Chính trực
                  </div>
                </div>
              </div>
              <div class="pageVision-item">
                <button class=" vision-btn" type="button" data-bs-toggle="collapse" data-bs-target="#vision-item-4" aria-expanded="false" aria-controls="vision-item-4">
                  CAM KẾT
                </button>
                <div class="collapse" id="vision-item-4">
                  <div class="vision-content">
                    <ul>
                      <li>Con tự tin nói tiếng Anh</li>
                      <li>Con làm chủ kỹ năng tương lai</li>
                      <li>Nền tảng vững vàng để con thành công</li>
                      <li>Giáo viên có bằng cấp chuyên môn cao</li>
                      <li>Trải nghiệm học tập toàn diện, hiện đại</li>
                      <li>Luôn đồng hành chặt chẽ cùng bố mẹ</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="vision-right-wrap">
              <div class="vision-img-wrap animated fadeIn delay-750 go on-show">
                <div class="img-vision-contain">
                  <img src="../../assets/images/children-1.png" alt="" class="vision-img">
                </div>
              </div>
              <div class="vision-img-wrap animated fadeIn delay-750 go">
                <div class="img-vision-contain">
                  <img src="../../assets/images/children-2.png" alt="" class="vision-img">
                </div>
              </div>
              <div class="vision-img-wrap animated fadeIn delay-750 go">
                <div class="img-vision-contain">
                  <img src="../../assets/images/children-3.png" alt="" class="vision-img">
                </div>
              </div>
              <div class="vision-img-wrap animated fadeIn delay-750 go">
                <div class="img-vision-contain">
                  <img src="../../assets/images/children-4.png" alt="" class="vision-img">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="wave-jouney-start-wrap ">
          <img class="wave-start-jouney img-inner" src="../../assets/images/wave-Vector.svg" />
        </div>
        <div class="teacher-wrap">
          <div class="teacher-inner">
            <div class="teacher-title">ĐỘI NGŨ GIÁO VIÊN GIÀU KINH NGHIỆM</div>
            <div class="teacher-intro-content">
              <div class="teacher-slide teacherSlider" id="teacher-carousel">
                <div class="teacher-info">
                  <div class="teacher-img-wrap">
                    <img src="../../assets/images/joe.png" alt="" class="teacher-img">
                  </div>
                  <div class="teacher-name">Joseph Black</div>
                  <div class="teacher-role"> GĐ Học vụ (LoDuHi Thái Hà) </div>
                  <div class="teacher-des">Cảm giác hạnh phúc nhất đối với tôi là khi học trò yêu thích học hỏi.</div>
                </div>
                <div class="teacher-info">
                  <div class="teacher-img-wrap">
                    <img src="../../assets/images/stephen.jpg" alt="" class="teacher-img">
                  </div>
                  <div class="teacher-name">Stephen Fessler</div>
                  <div class="teacher-role"> Giáo viên (LoDuHi Bắc Ninh) </div>
                  <div class="teacher-des">Nếu một đứa trẻ không thể học theo cách chúng ta dạy, có lẽ chúng ta nên dạy theo cách chúng học.</div>
                </div>
                <div class="teacher-info">
                  <div class="teacher-img-wrap">
                    <img src="../../assets/images/amiee.jpg" alt="" class="teacher-img">
                  </div>
                  <div class="teacher-name">Amiee Thomas</div>
                  <div class="teacher-role"> Giáo viên (LoDuHi Hào Nam) </div>
                  <div class="teacher-des">Những thầy cô giỏi nhất dạy bằng trái tim, chứ không từ sách vở.</div>
                </div>
                <div class="teacher-info">
                  <div class="teacher-img-wrap">
                    <img src="../../assets/images/alisa.png" alt="" class="teacher-img">
                  </div>
                  <div class="teacher-name">Alisa Kartyshova</div>
                  <div class="teacher-role"> Giáo viên (LoDuHi Phố Huế) </div>
                  <div class="teacher-des">Chúng ta hãy nhớ rằng một đứa trẻ, một giáo viên, một quyển sách và một cái bút có thể thay đổi cả thế giới.</div>
                </div>
                <div class="teacher-info">
                  <div class="teacher-img-wrap">
                    <img src="../../assets/images/richard.jpg" alt="" class="teacher-img">
                  </div>
                  <div class="teacher-name">Richard Anthony Light</div>
                  <div class="teacher-role"> Giáo viên (LoDuHi Thái Hà)</div>
                  <div class="teacher-des">Nhìn thấy học trò tiến bộ từng ngày là nguồn động viên tinh thần lớn nhất với tôi.</div>
                </div>
              </div>
              <button class="carousel-control-prev  teacher-control-left" type="button" data-bs-target=".teacherSlider" aria-label="Previous">
                <span class="carousel-control-prev-icon intro-control-next intro-control-icon-prev" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button id="teacher-carousel-next" class=" slick-next slick-arrow carousel-control-next  teacher-control-right" type="button" data-bs-target=".teacherSlider" data-bs-slide="Next">
                <span class="carousel-control-next-icon  intro-control-icon-next" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>

            </div>
          </div>
        </div>
        <div class="wave-jouney-start-wrap ">
          <img class="wave-start-jouney img-inner" src="../../assets/images/wave-infrastructure.svg" />
        </div>
        <!--Instrucment-section-->
        <div class="instrucment-wrap">
          <div class="instruct-inner">
            <div class="instruct-title">Cơ sở vật chất </div>
            <div class="instruct-content">
              <div class="instruct-slide">
                <div class="slider-for-instruct instructSlider">
                  <div class="instructSlidler-item">
                    <img class="img-inner" src="../../assets/images/instruct-1.jpg" />
                  </div>
                  <div class="instructSlidler-item">
                    <img class="img-inner" src="../../assets/images/instruct-2.jpg" />
                  </div>
                  <div class="instructSlidler-item">
                    <img class="img-inner" src="../../assets/images/instruct-3.jpg" />
                  </div>
                  <div class="instructSlidler-item">
                    <img class="img-inner" src="../../assets/images/instruct-4.jpg" />
                  </div>
                </div>
                <button class="carousel-control-prev instruct-control-prev" type="button" data-bs-target=".slider-for" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon intro-control-next intro-control-icon-prev" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next instruct-control-next-wrap" type="button" data-bs-target=".slider-for" data-bs-slide="next">
                  <span class="carousel-control-next-icon  intro-control-icon-next" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="inStructSlidePagging">
                <div class="slider-nav instructNavigation">
                  <div class="instructNav-item">
                    <div class="instruct-item-wrap">
                      <img src="../../assets/images/instruct-1.jpg" alt="" class="introNavImg">
                    </div>
                  </div>
                  <div class="instructNav-item">
                    <div class="instruct-item-wrap">
                      <img src="../../assets/images/instruct-2.jpg" alt="" class="introNavImg">
                    </div>
                  </div>
                  <div class="instructNav-item">
                    <div class="instruct-item-wrap">
                      <img src="../../assets/images/instruct-3.jpg" alt="" class="introNavImg">
                    </div>
                  </div>
                  <div class="instructNav-item">
                    <div class="instruct-item-wrap">
                      <img src="../../assets/images/instruct-4.jpg" alt="" class="introNavImg">
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="Course-list-wrap">
                  <div class="Course-list-inner">
                    <div class="Course-list-title">Danh Sách lớp</div>
                    <div class="course-list-content">
                      <div class="course-slide">
                        <div class="slider-for-course courseSlider">
                          <div class="courseSlidler-item">
                            <img  class="img-inner" src="../../assets/images/instruct-1.jpg"/>  
                          </div>
                          <div class="courseSlidler-item">
                            <img class="img-inner" src="../../assets/images/instruct-2.jpg"/>  
                          </div>
                          <div class="courseSlidler-item">
                            <img class="img-inner" src="../../assets/images/instruct-3.jpg"/>  
                          </div>
                          <div class="courseSlidler-item">
                            <img class="img-inner" src="../../assets/images/instruct-4.jpg"/>  
                          </div>
                        </div>
                        <button class="carousel-control-prev course-control-prev" type="button" data-bs-target=".slider-for" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon intro-control-next intro-control-icon-prev" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next course-control-next-wrap" type="button" data-bs-target=".slider-for" data-bs-slide="next">
                          <span class="carousel-control-next-icon  intro-control-icon-next" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div> -->
      </div>
      <!-- danh sach lop hoc -->
      <div class="instrucment-wrap">
        <div class="instruct-inner">
          <div class="instruct-title">Danh sách lớp </div>
          <div class="instruct-content">
            <div class="instruct-slide">
              <div class="slider-for-instruct instructSlider">
                <div class="instructSlidler-item">
                  <img class="img-inner" src="../../assets/images/instruct-1.jpg" />
                </div>
                <div class="instructSlidler-item">
                  <img class="img-inner" src="../../assets/images/instruct-2.jpg" />
                </div>
                <div class="instructSlidler-item">
                  <img class="img-inner" src="../../assets/images/instruct-3.jpg" />
                </div>
                <div class="instructSlidler-item">
                  <img class="img-inner" src="../../assets/images/instruct-4.jpg" />
                </div>
              </div>
              <button class="carousel-control-prev instruct-control-prev" type="button" data-bs-target=".slider-for" data-bs-slide="prev">
                <span class="carousel-control-prev-icon intro-control-next intro-control-icon-prev" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next instruct-control-next-wrap" type="button" data-bs-target=".slider-for" data-bs-slide="next">
                <span class="carousel-control-next-icon  intro-control-icon-next" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
            <div class="inStructSlidePagging">
              <div class="slider-nav instructNavigation">

                <?php $i = 1;
                foreach ($dataClassOnOff as $listClassOn) :
                  $nameTeacher = dataTeacherByMaLop($listClassOn['MaLop'], $connection);
                  foreach ($nameTeacher as $name) {
                    $s = $name['TenGV'];
                  }
                ?>
                  <div class="instructNav-item">
                    <div class="instruct-item-wrap">
                      <div class="introNavImg">
                        <div class="listClassOn<?php echo $i++ ?>">
                          <a href="                          
                          registerClass.php?malop=<?php echo $listClassOn['MaLop'] ?>                          
                          ">
                            <p> Mã lớp: <?php echo $listClassOn['MaLop'] ?></p>
                            <p> Tên lớp: <?php echo $listClassOn['TenLop'] ?></p>
                            <p> Tên giáo viên: <?php echo $s ?></p>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                  if ($i == 3) {
                    $i = 1;
                  }
                endforeach ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Footer-->
      <div class="Footer">
        <div class="Footer-inner">
          <div class="Footer-title">HÃY CÙNG LODUHI KHƠI SÁNG TÌNH YÊU HỌC TẬP NGAY HÔM NAY !</div>
          <div class="Footer-content-wrap">
            <div class="Footer-content-bg">
              <img class="img-inner" src="../../assets/images/backround-footer.png" />
            </div>
            <div class="Footer-content-inner">
              <div class="Footer-content-block">
                <div class="Footer-content-block-content">Tổ chức Giáo dục Anh Quốc gần 30 năm kinh nghiệm</div>
                <img class="Footer-content-block-img" src="../../assets/images/a-3.png"></img>
              </div>
              <div class="Footer-content-flex-wrap">
                <div class="footer-word-wrap">
                  <img class="img-inner" src="../../assets/images/a-main.svg"></img>
                </div>
                <div class="Footer-content-item">
                  <div class="Footer-content-smitem">
                    <div class="Footer-content-smitem-text">Phương pháp giảng dạy tiêu chuẩn quốc tế</div>
                    <img src="../../assets/images/a-2.svg" class="Footer-content-smitem-img"></img>
                  </div>
                  <div class="Footer-content-smitem">
                    <img class="Footer-content-smitem-img" src="../../assets/images/a-4.png"></img>
                    <div class="Footer-content-smitem-text">Giáo trình độc quyền phù hợp lứa tuổi & bài thi quốc tế</div>
                  </div>
                </div>
                <div class="Footer-content-item">
                  <div class="Footer-content-smitem">
                    <div class="Footer-content-smitem-text">100% môi trường tiếng Anh với giáo viên nước ngoài kinh nghiệm</div>
                    <img class="Footer-content-smitem-img" src="../../assets/images/a-2.png"></img>
                  </div>
                  <div class="Footer-content-smitem">
                    <img class="Footer-content-smitem-img" src="../../assets/images/a-5.svg"></img>
                    <div class="Footer-content-smitem-text">Hệ thống quản lý học tập hàng đầu theo sát lộ trình học của con</div>
                  </div>
                </div>
              </div>
              <div class="footer-back">
                <div class="footer-box-wrap">
                  <div class="footer-back-left">
                    <img src="../../assets/images/logo-footer.png" alt="" class="footer-img-back">
                  </div>
                  <div class="footer-back-right">
                    <a class="footer-back-right-nav">Liên hệ</a>
                    <a class="footer-back-right-nav">Tuyển dụng</a>
                    <a class="footer-back-right-nav">Đối tác (ASP)</a>
                    <a class="footer-back-right-nav">Teach At LoDuHi</a>
                    <div class="footer-back-right-nav">
                      theo dõi chúng tôi tại
                      <div class="icon-flex">
                        <img src="../../assets/images/Vector.svg" alt="" class="fbicon" />
                        <img src="../../assets/images/Subtract.svg" alt="" class="ytcon" />
                        <img src="../../assets/images/social.svg" alt="" class="inicon" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="footer-span">
                  Copyright © 2022 LoDuHi English. All rights reserved.
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
<a href="../../assets/images/"></a>
  <script>
     var tenHS = <?php print_r($jstenHS); ?>;
     var detailStudent = <?php print_r($jsdetailStudent); ?>;

  const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" href="../main_pages/homeStudent.php">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./userStudent_class.php" >Thông tin lớp học</a>
  <a class="menubar-nav  last-nav" href="./userStudent_link.php">Liên kết với phụ huynh</a>

  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` + tenHS[0].TenHS + `</div>
     
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu" id ="a123">
              <li class="menubar-dropdown-item"><a  href="../personal/personal_Student.php">Thông tin cá nhân</a></li>
      
              <li class="menubar-dropdown-item">  <form action="" method="post"> <input type="submit" name ="btn-logout"  id ="btn-logout" value ="Đăng xuất" style="border: none;background-color: unset;"></form></li>          </ul>
          </ul>
        </div>
    </div>
  </div>
</div>

</div>`
  //isAuthentication === true
  document.querySelector("#menu-bar").innerHTML = authMenuBarHTMl
  var $ = document.querySelector.bind(document)
var $$ = document.querySelectorAll.bind(document)


$(".menubar-drop-btn").onclick = ()=>{
   
    $(".menubar-dropdown-menu").classList.toggle("menubar-show")
 
}

var img2 = document.querySelector(".menubar-avt");
    if (detailStudent[0].GioiTinh == "Nam") {
    
        img2.src = "../../assets/images/Student-male-icon.png";
    } else {
        
        img2.src = "../../assets/images/Student-female-icon.png";
    }

  </script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!--boostrap.js-->
  <script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
  <!--slick.js-->
  <script type="text/javascript" src="../../plugins/slick-1.8.1/slick/slick.min.js"></script>
  <script type="text/javascript" src="../../plugins/slick-1.8.1/slick/slick.min.js">
  </script>
  <script src="../home/home.js"></script>
 
  <!-- <script src="../common/menubar.js"></script> -->
</body>

</html>