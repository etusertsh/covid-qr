# covid-qr
防疫實名制QRcode<br>
本案為防疫所需，使用事先申請取得 QR Code後，掃描入場的系統程式。版面及部份機制模仿自臺北科技大學防疫通行證，但擴充為多人多活動且結合 QR Code Scanner Tools 為整合系統。<br>
功能：<br>
1、多人管理，多活動系統，依據不同活動性質產生對應的訪客 QR Code。<br>
2、活動分為短期型（有結束時間）及常設型（無固定時間）<br>
3、程式為 PHP + MySQL，採用 Smarty2 模板引擎。<br>
4、CSS 採 Bootstrap5.0，QR Code 產生採 Google Chart API<br>
4、QR Code Scanner Tools 採用 instascan 的 JS 程式。<br><br>

安裝：<br>
1、MySQL資料庫欄位結構 mysql/covid-qr.sql<br>
2、參數修改 config/config.php 及 include/db.class.php<br>
3、因使用 instascan 的 JS QRCode Tools，須運作於 HTTPS 下。<br>

