<?php

namespace App\Helpers;

class GData
{
    public static array $mail_data = [
        'change_schedule_request' => [
            'confirm'     => [
                'view'    => 'mail-forms.change-schedule-request',
                'subject' => 'Xác nhận yêu cầu thay đổi lịch giảng',
                'content' => 'Hệ thống đã tiếp nhận yêu cầu thay đổi lịch giảng với lí do:',
            ],
            'accept'      => [
                'view'    => 'mail-forms.change-schedule-request',
                'subject' => 'Yêu cầu thay đổi lịch giảng được phê duyệt',
                'content' => 'Yêu cầu thay đổi lịch giảng đã được trưởng bộ môn phê duyệt',
            ],
            'accept_room' => [
                'view'    => 'mail-forms.change-schedule-request',
                'subject' => 'Yêu cầu thay đổi lịch giảng được cấp phòng học',
                'content' => 'Yêu cầu thay đổi lịch giảng đã được phòng quản lý giảng đường cấp phòng học',
            ],
            'cancel'      => [
                'view'    => 'mail-forms.change-schedule-request',
                'subject' => 'Hủy yêu cầu thay đổi lịch giảng',
                'content' => 'Hủy thành công yêu cầu thay đổi lịch giảng',
            ],
            'deny'        => [
                'view'    => 'mail-forms.change-schedule-request',
                'subject' => 'Yêu cầu tay đổi lịch giảng bị từ chối',
                'content' => 'Yêu cầu thay đổi lịch giảng đã bị trưởng bộ môn từ chối với lí do:',
            ],
            'deny_room'   => [
                'view'    => 'mail-forms.change-schedule-request',
                'subject' => 'Yêu cầu tay đổi lịch giảng không được cấp phòng',
                'content' => 'Yêu cầu thay đổi lịch giảng đã bị phòng quản lý giảng đường từ chối do không tìm được phòng trống',
            ],
        ],
    ];

    public static array $id_faculties_not_query = [
        'LLCT', 'GDTC', 'GDQP'
    ];

    public static array $colors = [
        '#a8cef1',
        '#3682db',
        '#8dda71',
        '#34b41f',
        '#e29398',
        '#b8474e',
        '#fcc068',
        '#ff8a00',
        '#dab3f9',
        '#7b439e',
        '#fee797',
        '#fcbb14',
        '#ea97c4',
        '#bd65a4',
        '#7fd7cc',
        '#2fad96',
        '#d4aca2',
        '#9d6f64',
        '#d2e9a2',
        '#aadc42',
        '#a0c5df',
    ];

    public static $current;

    public static array $faculty_class_and_major_info = [
        'CKOTO'        => ['name'       => 'Lớp Cơ khí ô tô',
                           'id_faculty' => 'CK'],
        'CDT'          => ['name'       => 'Lớp Cơ điện tử',
                           'id_faculty' => 'CK'],
        'CNCTCK'       => ['name'       => 'Lớp Công nghệ chế tạo cơ khí',
                           'id_faculty' => 'CK'],
        'MXD'          => ['name'       => 'Lớp Máy xây dựng',
                           'id_faculty' => 'CK'],
        'TDHTKCK'      => ['name'       => 'Lớp Tự động hoá thiết kế cơ khí',
                           'id_faculty' => 'CK'],
        'VLVH.CNTT'    => ['name'       => 'Lớp Công nghệ thông tin (Hệ vừa làm vừa học)',
                           'id_faculty' => 'CNTT'],
        'CNTT'         => ['name'       => 'Lớp Công nghệ thông tin',
                           'id_faculty' => 'CNTT'],
        'CTGTCC'       => ['name'       => 'Lớp Công trình giao thông công chính',
                           'id_faculty' => 'CT'],
        'CTGTDT'       => ['name'       => 'Lớp Công trình giao thông đô thị',
                           'id_faculty' => 'CT'],
        'CDBO'         => ['name'       => 'Lớp Kỹ thuật cầu đường bộ',
                           'id_faculty' => 'CT'],
        'CDS'          => ['name'       => 'Lớp Kỹ thuật cầu đường sắt',
                           'id_faculty' => 'CT'],
        'KTGIS'        => ['name'       => 'Lớp Kỹ thuật GIS và trắc địa công trình giao thông',
                           'id_faculty' => 'CT'],
        'CH'           => ['name'       => 'Lớp Kỹ thuật xây dựng cầu',
                           'id_faculty' => 'CT'],
        'KTXDCTGT(QT)' => ['name'       => 'Lớp Kỹ thuật xây dựng công trình giao thông (QT)',
                           'id_faculty' => 'CT'],
        'DHMETRO'      => ['name'       => 'Lớp Kỹ thuật xây dựng đường hầm và metro',
                           'id_faculty' => 'CT'],
        'DSDT'         => ['name'       => 'Lớp Kỹ thuật đường sắt đô thị',
                           'id_faculty' => 'CT'],
        'TDH'          => ['name'       => 'Lớp Tự động hoá thiết kế cầu đường',
                           'id_faculty' => 'CT'],
        'DBO'          => ['name'       => 'Lớp Đường bộ',
                           'id_faculty' => 'CT'],
        'KTDTVT'       => ['name'       => 'Lớp Kỹ thuật điện tử viễn thông',
                           'id_faculty' => 'DDT'],
        'KTDTTHCN'     => ['name'       => 'Lớp Kỹ thuật điện tử và tin học công nghiệp',
                           'id_faculty' => 'DDT'],
        'KTĐK&TDH'     => ['name'       => 'Lớp Kỹ thuật điều khiển và tự động hoá',
                           'id_faculty' => 'DDT'],
        'TBD'          => ['name'       => 'Lớp Trang bị điện trong công nghiệp và giao thông',
                           'id_faculty' => 'DDT'],
        'KCXD'         => ['name'       => 'Lớp Kết cấu xây dựng',
                           'id_faculty' => 'KTXD'],
        'KTHTDT'       => ['name'       => 'Lớp Kỹ thuật hạ tầng đô thị',
                           'id_faculty' => 'KTXD'],
        'VLCNXDGT'     => ['name'       => 'Lớp Vật liệu và công nghệ xây dựng',
                           'id_faculty' => 'KTXD'],
        'XDDDCN'       => ['name'       => 'Lớp Xây dựng dân dụng và công nghiệp',
                           'id_faculty' => 'KTXD'],
        'KTVTOTO'      => ['name'       => 'Lớp Kinh tế vận tải ô tô',
                           'id_faculty' => 'VTKT'],
        'KTVTDL'       => ['name'       => 'Lớp Kinh tế vận tải và du lịch',
                           'id_faculty' => 'VTKT'],
        'QTDNBCVT'     => ['name'       => 'Lớp Quản trị doanh nghiệp bưu chính viễn thông',
                           'id_faculty' => 'VTKT'],
        'QTDNVT'       => ['name'       => 'Lớp Quản trị doanh nghiệp vận tải',
                           'id_faculty' => 'VTKT']
    ];
}
