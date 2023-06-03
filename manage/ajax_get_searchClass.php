<?php 
 include "../lib/FunctionClass.php";
 $data = $_POST['data'];
 $a = $data['key'];
 $idSelect = $data['province_id'];
 if( $idSelect == 1) :
  $searchClassOn = searchClassOn($a,$connection);
    foreach($searchClassOn as $datas ):
        $maLop = $datas['MaLop'];
        $nameTeacher = dataTeacherByMaLop($maLop, $connection);
        $schedules = dataSchedulesByMaLop($maLop, $connection); ?>
        <a class='class' href='DetailsClass.php?maLop=<?php echo $maLop ?>'>
            <div>
                <div class='class-code1'>
                    <?php echo $datas['MaLop'] ?>
                </div>
                <div class='info'>
                    <h2>
                        <?php echo  $datas['TenLop'] ?>
                    </h2>
                    <p>Giảng viên:
                        <?php foreach ($nameTeacher as $nameTeachers) {
                            echo	 $nameTeachers['TenGV'];
                        } ?>
                    </p>
                    <div class='column'>
                        <p>Thời gian:
                        </p>
                        <div class='center'>
                            <?php
                            foreach ($schedules as $listschedules) {

                                echo $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time'];
                                echo "<br>";
                            }
                            ?>
                        </div>
                    </div>

                    <p>Lứa tuổi:
                        <?php echo  $datas['LuaTuoi'] ?>
                    </p>
                    <p>Số lượng học sinh:
                        <?php echo $datas['SLHS'] . ' / ' . $datas['SLHSToiDa'] ?>
                    </p>
                </div>
            </div>
            <div class='details'>Xem chi tiết</div>
        </a>
<?php endforeach ?>
<?php endif ?>

<?php 
 if( $idSelect == 0) :
    $searchClassOn = searchClassOff($a,$connection);
    foreach($searchClassOn as $datas ):
        $maLop = $datas['MaLop'];
        $nameTeacher = dataTeacherByMaLop($maLop, $connection);
        $schedules = dataSchedulesByMaLop($maLop, $connection); ?>
        <a class='class' href='DetailsClass.php?maLop=<?php echo $maLop ?>'>
            <div>
                <div class='class-code<?php echo $datas['TrangThai'] ?>'>
                    <?php echo $datas['MaLop'] ?>
                </div>
                <div class='info'>
                    <h2>
                        <?php echo  $datas['TenLop'] ?>
                    </h2>
                    <p>Giảng viên:
                        <?php foreach ($nameTeacher as $nameTeachers) {
                            echo	 $nameTeachers['TenGV'];
                        } ?>
                    </p>
                    <div class='column'>
                        <p>Thời gian:
                        </p>
                        <div class='center'>
                            <?php
                            foreach ($schedules as $listschedules) {

                                echo $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time'];
                                echo "<br>";
                            }
                            ?>
                        </div>
                    </div>

                    <p>Lứa tuổi:
                        <?php echo  $datas['LuaTuoi'] ?>
                    </p>
                    <p>Số lượng học sinh:
                        <?php echo $datas['SLHS'] . ' / ' . $datas['SLHSToiDa'] ?>
                    </p>
                </div>
            </div>
            <div class='details'>Xem chi tiết</div>
        </a>
<?php endforeach ?>
<?php endif ?>

