=> หน้า Customer.index
เพิ่มการเลืกสัญญา ตามประเภท PLM (1) กับสํญญา 50 (2) 
เลือกแสดงข้อมูลตามสถานะ ผ่าน กับ ไม่ผ่าน
ค้นหา
_______________________________________

  <!-- {!! $customers->links('pagination::bootstrap-5') !!} -->

  ค้นหา

-เลือก Past 2 ,3 (option)


ช่อง
  -วันนัดชำระ
  -วันลงพื้นที่
  -Power App
  -บันทึก
  ปรับให้สามารถอัพเดทได้


อัพเดทข้อมูลใหม่แต่ละเดือน 
ดูข้อมูลแดชบอร์ดย้อนหลังได้แต่ละเดือน

---sql---
UPDATE `tbl_customers` SET `typeLoan`='1' WHERE `contractNumber` LIKE '%L02-%';
UPDATE `tbl_customers` SET `typeLoan`='1' WHERE `contractNumber` LIKE '%L03-%';
UPDATE `tbl_customers` SET `typeLoan`='1' WHERE `contractNumber` LIKE '%L04-%';
UPDATE `tbl_customers` SET `typeLoan`='1' WHERE `contractNumber` LIKE '%P01-%';
UPDATE `tbl_customers` SET `typeLoan`='1' WHERE `contractNumber` LIKE '%M05-%';
UPDATE `tbl_customers` SET `typeLoan`='1' WHERE `contractNumber` LIKE '%L22-%';
UPDATE `tbl_customers` SET `typeLoan`='1' WHERE `contractNumber` LIKE '%L06-%';

UPDATE `tbl_customers` SET `typeLoan`='2' WHERE `contractNumber` LIKE '%30-%';
UPDATE `tbl_customers` SET `typeLoan`='2' WHERE `contractNumber` LIKE '%50-%';



MKREE อันดเดียวกับ MKRE ,SRIN อยู่กลุ่มใบตอง



1. Searchtracknumber == '' && $traceEmployee == '' && $searchtype == '' && $searchstatus == '' && $groupDebt == ''

1. Searchtracknumber != '' && $traceEmployee == '' && $searchtype == '' && $searchstatus == '' && $groupDebt == ''
2. Searchtracknumber != '' && $traceEmployee != '' && $searchtype == '' && $searchstatus == '' && $groupDebt == ''
2. Searchtracknumber != '' && $traceEmployee != '' && $searchtype != '' && $searchstatus == '' && $groupDebt == ''
2. Searchtracknumber != '' && $traceEmployee != '' && $searchtype != '' && $searchstatus != '' && $groupDebt != ''

1. Searchtracknumber == '' && $traceEmployee == '' && $searchtype == '' && $searchstatus == '' && $groupDebt != ''
1. Searchtracknumber == '' && $traceEmployee == '' && $searchtype == '' && $searchstatus != '' && $groupDebt != ''
1. Searchtracknumber == '' && $traceEmployee == '' && $searchtype != '' && $searchstatus != '' && $groupDebt != ''
1. Searchtracknumber == '' && $traceEmployee != '' && $searchtype != '' && $searchstatus != '' && $groupDebt != ''



2. Searchtracknumber == '' && $traceEmployee != '' && $searchtype !== '' && $searchstatus == ''
   Searchtracknumber == '' && $traceEmployee == '' && $searchtype != '' && $searchstatus == ''

   Searchtracknumber == '' && $traceEmployee != '' && $searchtype != '' && $searchstatus == ''
   Searchtracknumber == '' && $traceEmployee != '' && $searchtype == '' && $searchstatus != ''


   Searchtracknumber != '' && $traceEmployee == '' && $searchtype != '' && $searchstatus == ''
   Searchtracknumber != '' && $traceEmployee == '' && $searchtype == '' && $searchstatus != ''



  Searchtracknumber != '' && $teamGroup != '' && $searchtype == '' && $searchstatus == ''
  Searchtracknumber != '' && $teamGroup != '' && $searchtype != '' && $searchstatus == ''
  Searchtracknumber != '' && $teamGroup != '' && $searchtype != '' && $searchstatus != ''
  Searchtracknumber == '' && $teamGroup != '' && $searchtype != '' && $searchstatus != ''
  Searchtracknumber == '' && $teamGroup != '' && $searchtype !== '' && $searchstatus == ''
  Searchtracknumber == '' && $teamGroup != '' && $searchtype != '' && $searchstatus == ''
 

$traceEmployee == '' &&  $searchstatus  == ''&& $nonlist  =='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  == ''&& $nonlist  =='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  != ''&& $nonlist  =='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  != ''&& $nonlist  !='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  != ''&& $nonlist  !='' && $groupDebt  != '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  != ''&& $nonlist  !='' && $groupDebt  != '' &&  Searchtracknumber != ''
$traceEmployee != '' &&  $searchstatus  != ''&& $nonlist  !='' && $groupDebt  != '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  != ''&& $nonlist  !='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  != ''&& $nonlist  =='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee != '' &&  $searchstatus  == ''&& $nonlist  =='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee == '' &&  $searchstatus  != ''&& $nonlist  =='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee == '' &&  $searchstatus  == ''&& $nonlist  !='' && $groupDebt  == '' &&  Searchtracknumber == ''
$traceEmployee == '' &&  $searchstatus  == ''&& $nonlist  =='' && $groupDebt  != '' &&  Searchtracknumber == ''
$traceEmployee == '' &&  $searchstatus  == ''&& $nonlist  =='' && $groupDebt  == '' &&  Searchtracknumber != ''

      

        -เรียงข้อมูลจากวันดีลงวด *
        - ค้นหาตามกบุ่มค้างงวด
         -ค้นหา เรียงตามคอลัมน์ที่เลือก ทีมตามใน non กลุ่มค้างงวด สถานะ
        - เพิ่มสถานะ 
        -เพิ่มคอลัมรวมหน้าเลขที่สัญญา NON1 NON2
      
        -หน้าแก้ไขเพิ่ม txtarea ชื่อ action plan + เพิ่มคอลัมน์ใน ฐานข้อมูลด้วย

        ทำกลุ่มค้างงงวด + สถานะ


30-09-65

     -> Dashboard 
      -ตีเส้นตาราง /
      -ฟอนต์มีหัว 
      -สีแถวสลับ(สีชัด)
      -เพิ่มตารางทีมรวม ทีม A ทีม B

    -> หน้าติดตามลูกค้า
      -เอาเบอร์โทรออก
      -เพิ่มคอลัมน์ วันที่ลงพื้นที่ กับวันที่ power App
      -เพิ่มหน้าสำหรับของหัวหน้า (เพิ่มแทป)
        
        1.เลือกทีม 2.ล็อดเงื่อนไข (Past2,Past3)ทุกสถานะ (typeLoan 1)
          ถ้าไม่ใช่ Past2,3 ล็อคสถานะ ส่งรายงานหัวหน้า ,ส่งรายงาน GM (typeLoan 1)

        2. ส่งรายงานหัวหน้า ,ส่งรายงาน GM (typeLoan 2)

      (เพื่มแถว โน้ต กับ action plan)

        -ปรับขนาดฟอนต์
        -แก้ Poweapp เป็นวันที่
        โชว์วันที่แค่วันกับเดือน
      -------


      exportExcel = () =>{
Swal.fire({
  title: 'รหัสการ Export',
  input: 'text',
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'OK',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
    if(login = 'test'){
      window.location('google.com')
    }
        },
   
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: `${result.value.login}'s avatar`,
      imageUrl: result.value.avatar_url
    })
  }
})
}




css 

body {
  font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
} asd


html

<button onclick="exportExcel()">Export</button>



12/10/65
-เปลี่ยนรูปแบบวันที่ ให้เป็น วันเดือนปี
-บั๊คหน้า leader ตอนค้นหา แสดงข้อมูลไม่ขึ้น *
-เพิ่มสถานะ แจ้งค่างวด *
-วันที่ชำระล่าสุด ในตารางหน้า Leader & ติดตามข้อมูลลูกค้า หลังคอลัมน์ยอดจ่ายขั้นต่ำ *
-กรองการต้นหา ประเภทสัญญา + สถานะ ไม่ขึ้น *
-แก้บั๊คบนแถบค้นหาจากบราวเซอร์

15/10/65
- เพื่มเปอร์เซ็น ลงพื้นที่ แต่ละสาขา 
- เพื่มเปอร์เซ็น ไม่ผ่าน แต่ละสาขา มีเลขสัญญาอะไรบ้าง
18/10/65
- เพื่มเปอร์เซ็น ลงพื้นที่ เลือกจากวันลงพื้นที่เริ่มจากวันที่ลง power app ถ้่มีข้อมูล 1 ไม่มี 0
- วันที่ลง POwer app / วันที่นัดลงพื้นที่
-dashboard แยกสาขาย่อย pie chart ทีมที่ไม่ผ่าน(ทุกสถานะที่ไม่ใช่คำว่า ผ่าน) เลขที่สัญญาประเภทไหนบ้าง
-ทีม A ถามเรื่อง NT
-fixed table

28/10/65
- แก้ไข เปอร์ลงพื้นที่ (ตัวหารเป็นจำนวนวันที่นัดลงพื้นที่)
- error แสดงทีมทั้งหมด leader

- เช็ค ajax update ของทุก ๆ user อีกรอบ

