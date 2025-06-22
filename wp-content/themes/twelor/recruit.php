<?php
/**
 * Template Name: リクルート
 */
get_header();
?>

<div class="container py-5">
    <h1 class="recruit-section-title"><?php echo esc_html(get_the_title()); ?></h1>

    <div class="col-12 position-relative">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit_bg.jpg" alt="求人募集背景" class="img-fluid recruit-bg">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/openingstaff.png" alt="求人募集" class="recruit">
    </div>

    <div class="requirements-table-container">
        <table class="requirements-table">
            <tbody>
                <tr>
                    <th class="table-header">業種</th>
                    <td class="table-content">
                        <div class="job-details">
                            <p>お客様のネイルをお手伝いする仕事</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="table-header">対象職種</th>
                    <td class="table-content">
                        <p>ネイリスト</p>
                    </td>
                </tr>
                <tr>
                    <th class="table-header">給与</th>
                    <td class="table-content">
                        <div class="salary-details">
                            <div>
                                <p><strong>【正社員】月給250,000円以上</strong></p>
                                <p>●例　実働8.5/休憩1.5<br>
                                    250.440円　月24日出勤<br>
                                    240.000円　月23日出勤<br>
                                    229.500円　月22日出勤<br>
                                    219.100円　月21日出勤<br>
                                    208.600円　月20日出勤<br>
                                </p>
                            </div>
                            
                            <div>
                                <p><strong>【アルバイト・パート】時給1,100円～1,300円</strong></p>
                                <p>
                                    ※土日祝や夜の時間も出勤可能な方<br>
                                    勤務初日から同時給が嬉しい♪<br>
                                    研修中も安心して勤めることができます！<br>
                                </p>
                            </div>
                            
                            <div>
                                <p><strong>【業務委託】 完全歩合</strong></p>
                                <p>
                                    ※完全歩合制　売上の50％<br>
                                    ※経験・能力を考慮し、優遇いたします。<br>
                                    ※1日3～4時間勤務より応相談<br>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="table-header">勤務地</th>
                    <td class="table-content">
                        <p>東京都豊島区池袋2-40-13 VORT1池袋ビル3F</p>
                    </td>
                </tr>
                <tr>
                    <th class="table-header">勤務時間</th>
                    <td class="table-content">
                        <div>
                            <p><strong>【正社員】</strong><br>
                                平日:11:00～23:00(のうちシフト制)<br>
                                土曜・日曜・祭日:10:00～23:00(のうちシフト制)
                            </p>
                            <p><strong>【アルバイト】</strong><br>
                                週2日、1日5時間～
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="table-header">休日</th>
                    <td class="table-content">
                        <div>
                            <p><strong>【正社員】</strong>
                            <ul>
                                <li>週休2日</li>
                                <li>有給休暇</li>
                                <li>産休・育休</li>
                            </ul>
                            <p><strong>【アルバイト】</strong></p>
                            <ul>
                                <li>希望休</li>
                                <li>有給休暇</i>
                                <li>産休・育休</li>
                            </ul>
                            <p><strong>【業務委託】</strong></p>
                            <ul>
                                <li>応相談</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="table-header">待遇</th>
                    <td class="table-content">
                        <div>
                            <p><strong>【共通】</strong></p>
                            <ul>
                                <li>制服貸与</li>
                            </ul>
                            <p><strong>【正社員】</strong></p>
                            <ul>
                                <li>交通費支給(10,000円/月迄)</li>
                                <li>有給休暇(勤務半年後から10日間発生)</li>
                                <li>産休・育休</li>
                                <li>社会保険(健康保険・厚生年金・雇用保険・労災加入)</li>
                                <li>決算賞与/年1回(年度業績に応じて)</li>
                                <li>健康診断</li>
                            </ul>
                            <p><strong>【アルバイト】</strong></p>
                            <ul>
                                <li>交通費支給(10,000円/月迄)</li>
                                <li>有給休暇(勤務半年後から発生)</li>
                                <li>社会保険・厚生年金・雇用保険・労災加入(勤務時間・日数によって)</li>
                                <li>決算賞与/年1回(年度業績に応じて)</li>
                                <li>健康診断(勤務時間・日数によって)</li>
                            </ul>
                            <p><strong>【業務委託】</strong></p>
                            <ul>
                                <li>最低保障給</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="table-header">応募資格</th>
                    <td class="table-content">
                        <div>
                            <ul>
                                <li><strong>1年以上の実務経験ある方</strong></li>
                                <li>幹部候補・店長候補も募集中!!</li>
                                <li>夕方からの勤務ができる方歓迎</li>
                                <li>土曜・日曜・祭日勤務できる方優遇</li>
                                <li>【アルバイト】は週2日、1日5時間～面接時に相談</li>
                                <li>20歳～35歳</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .recruit-section-title {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin: 30px auto;
        padding-bottom: 10px;
        width: 100%;
        border-bottom: 1px solid #ddd;
    }

    .requirements-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1rem;
    }

    .table-header {
        padding: 20px 25px;
        font-weight: 600;
        font-size: 1.1rem;
        text-align: left;
        vertical-align: top;
        width: 150px;
        border-bottom: 1px solid #e0e0e0;
    }

    .table-content {
        padding: 20px 25px;
        color: #333;
        line-height: 1.7;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: top;
    }

    .requirements-table tr:last-child th.table-header,
    .requirements-table tr:last-child td.table-content {
        border-bottom: none;
    }

    .recruit-bg {
        height: 350px;
        width: 100%;
    }

    .recruit {
        position: absolute;
        top: 20%;
        left: 15%;
        transform: translate(-50%, -25%);
        width: 300px;
        height: 300px;
        z-index: 10;
    }

    @media (max-width: 768px) {
        .table-header {
            padding: 20px 0px;
            width: 50px;
        }
        .recruit {
            left: 25%;
        }
    }
</style>

<?php get_footer(); ?>