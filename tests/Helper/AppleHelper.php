<?php
namespace Tests\Helper;

use AppleBundle\Model\Receipt;
use Busuu\IosReceiptsApi\Model\AppStoreReceipt;

class AppleHelper
{
    private $receiptData = 'ewogICAgcG9kID0gNTA7CiAgICAicHVyY2hhc2UtaW5mbyIgPSAiZXdvSkluRjFZVzUwYVhSNUlpQTlJQ0l4SWpzS0NTSnZjbWxuYVc1aGJDMXdkWEpqYUdGelpTMWtZWFJsSWlBOUlDSXlNREUyTFRBNExURTJJREUyT2pReU9qVXpJRVYwWXk5SFRWUWlPd29KSW1KcFpDSWdQU0FpWTI5dExtSjFjM1YxTG1WdVoyeHBjMmd1WVhCd0lqc0tDU0p3ZFhKamFHRnpaUzFrWVhSbExXMXpJaUE5SUNJeE5EY3hNelkxTnpjek9ETTJJanNLQ1NKMlpYSnphVzl1TFdWNGRHVnlibUZzTFdsa1pXNTBhV1pwWlhJaUlEMGdJamd4T0RNeU1qVTFOU0k3Q2draWRISmhibk5oWTNScGIyNHRhV1FpSUQwZ0ltTnZiUzVpZFhOMWRTNWhjSEF1YzNWaWN6RXliVzl1ZEdodmNIUnBiMjVETG5KMWMzTnBZVEUwTnpFek5qVTNOek00TXpNaU93b0pJbkIxY21Ob1lYTmxMV1JoZEdVdGNITjBJaUE5SUNJeU1ERTJMVEE0TFRFMklEQTVPalF5T2pVeklFRnRaWEpwWTJFdlRHOXpYMEZ1WjJWc1pYTWlPd29KSW1sMFpXMHRhV1FpSUQwZ0lqRXdNakUyTlRReE1qSWlPd29KSW5CeWIyUjFZM1F0YVdRaUlEMGdJbU52YlM1aWRYTjFkUzVoY0hBdWMzVmljekV5Ylc5dWRHaHZjSFJwYjI1RExuSjFjM05wWVNJN0Nna2lkVzVwY1hWbExXbGtaVzUwYVdacFpYSWlJRDBnSWpFeU5tVXhZalF4TTJRd056VXlaalEwT0dKaFlqSTJPRFUyTjJZNU5ERXdabUZsWTJZMU5tUWlPd29KSW5WdWFYRjFaUzEyWlc1a2IzSXRhV1JsYm5ScFptbGxjaUlnUFNBaU1EY3dSak13UXpRdE1UbEJOQzAwT0RrM0xVSkNSakV0UVRWRE9VWTFNMFEzTkRjMUlqc0tDU0poY0hBdGFYUmxiUzFwWkNJZ1BTQWlNemM1T1RZNE5UZ3pJanNLQ1NKdmNtbG5hVzVoYkMxd2RYSmphR0Z6WlMxa1lYUmxMWEJ6ZENJZ1BTQWlNakF4Tmkwd09DMHhOaUF3T1RvME1qbzFNeUJCYldWeWFXTmhMMHh2YzE5QmJtZGxiR1Z6SWpzS0NTSnZjbWxuYVc1aGJDMXdkWEpqYUdGelpTMWtZWFJsTFcxeklpQTlJQ0l4TkRjeE16WTFOemN6T0RNMklqc0tDU0p2Y21sbmFXNWhiQzEwY21GdWMyRmpkR2x2YmkxcFpDSWdQU0FpWTI5dExtSjFjM1YxTG1Gd2NDNXpkV0p6TVRKdGIyNTBhRzl3ZEdsdmJrTXVjblZ6YzJsaE1UUTNNVE0yTlRjM016Z3pNeUk3Q2draVluWnljeUlnUFNBaU1pSTdDZ2tpY0hWeVkyaGhjMlV0WkdGMFpTSWdQU0FpTWpBeE5pMHdPQzB4TmlBeE5qbzBNam8xTXlCRmRHTXZSMDFVSWpzS2ZRPT0iOwogICAgc2lnbmF0dXJlID0gIkFwZHhKZHROd1BVMnJBNS9jbjNrSU8xT1RrMjVmZURLYTBhYWd5eVJ2ZVdsY0ZsZ2x2NlJGNnpua2lCUzN1bTlVYzdwVm9iK1BxWlIyVDh3eVZySE5wbG9mM0RYM0lxRE9sV3ErOTBhN1lsK3FyUjdBN2pXd3ZpdzcwOFBTKzY3UHlIUm5oTy9HN2JWcWdScEVyNkV1RnliaVUxRlhBaVhKYzZsczFZQXNzUXhBQUFEVnpDQ0ExTXdnZ0k3b0FNQ0FRSUNDR1VVa1UzWldBUzFNQTBHQ1NxR1NJYjNEUUVCQlFVQU1IOHhDekFKQmdOVkJBWVRBbFZUTVJNd0VRWURWUVFLREFwQmNIQnNaU0JKYm1NdU1TWXdKQVlEVlFRTERCMUJjSEJzWlNCRFpYSjBhV1pwWTJGMGFXOXVJRUYxZEdodmNtbDBlVEV6TURFR0ExVUVBd3dxUVhCd2JHVWdhVlIxYm1WeklGTjBiM0psSUVObGNuUnBabWxqWVhScGIyNGdRWFYwYUc5eWFYUjVNQjRYRFRBNU1EWXhOVEl5TURVMU5sb1hEVEUwTURZeE5ESXlNRFUxTmxvd1pERWpNQ0VHQTFVRUF3d2FVSFZ5WTJoaGMyVlNaV05sYVhCMFEyVnlkR2xtYVdOaGRHVXhHekFaQmdOVkJBc01Fa0Z3Y0d4bElHbFVkVzVsY3lCVGRHOXlaVEVUTUJFR0ExVUVDZ3dLUVhCd2JHVWdTVzVqTGpFTE1Ba0dBMVVFQmhNQ1ZWTXdnWjh3RFFZSktvWklodmNOQVFFQkJRQURnWTBBTUlHSkFvR0JBTXJSakYyY3Q0SXJTZGlUQ2hhSTBnOHB3di9jbUhzOHAvUndWL3J0LzkxWEtWaE5sNFhJQmltS2pRUU5mZ0hzRHM2eWp1KytEcktKRTd1S3NwaE1kZEtZZkZFNXJHWHNBZEJFakJ3Ukl4ZXhUZXZ4M0hMRUZHQXQxbW9LeDUwOWRoeHRpSWREZ0p2MllhVnM0OUIwdUp2TmR5NlNNcU5OTEhzREx6RFM5b1pIQWdNQkFBR2pjakJ3TUF3R0ExVWRFd0VCL3dRQ01BQXdId1lEVlIwakJCZ3dGb0FVTmgzbzRwMkMwZ0VZdFRKckR0ZERDNUZZUXpvd0RnWURWUjBQQVFIL0JBUURBZ2VBTUIwR0ExVWREZ1FXQkJTcGc0UHlHVWpGUGhKWENCVE16YU4rbVY4azlUQVFCZ29xaGtpRzkyTmtCZ1VCQkFJRkFEQU5CZ2txaGtpRzl3MEJBUVVGQUFPQ0FRRUFFYVNiUGp0bU40Qy9JQjNRRXBLMzJSeGFjQ0RYZFZYQWVWUmVTNUZhWnhjK3Q4OHBRUDkzQmlBeHZkVy8zZVRTTUdZNUZiZUFZTDNldHFQNWdtOHdyRm9qWDBpa3lWUlN0USsvQVEwS0VqdHFCMDdrTHM5UVVlOGN6UjhVR2ZkTTFFdW1WL1VndkRkNE53Tll4TFFNZzRXVFFmZ2tRUVZ5OEdYWndWSGdiRS9VQzZZNzA1M3BHWEJrNTFOUE0zd294aGQzZ1NSTHZYaitsb0hzU3RjVEVxZTlwQkRwbUc1K3NrNHR3K0dLM0dNZUVONS8rZTFRVDlucC9LbDFuaithQnc3QzB4c3kwYkZuYUFkMWNTUzZ4ZG9yeS9DVXZNNmd0S3Ntbk9PZHFUZXNicDBiczhzbjZXcXMwQzlkZ2N4Ukh1T01aMnRtOG5wTFVtN2FyZ09TelE9PSI7CiAgICAic2lnbmluZy1zdGF0dXMiID0gMDsKfQ==';

    public function getReceiptData()
    {
        return $this->receiptData;
    }

    /**
     * @param bool $expired
     * @return AppStoreReceipt
     */
    public function getStoreReceipt($expired = false)
    {
        $nowMs = time() * 1000;
        $storeReceipt = new AppStoreReceipt();
        $storeReceipt
            ->setExpiresDateMs($expired ? $nowMs - 100000 : $nowMs + 100000)
            ->setOriginalTransactionId('460000184056394')
            ->setProductId('com.busuu.app.subs1month.china_fr')
            ->setOriginalPurchaseDateMs(1466520984000)
        ;

        return $storeReceipt;
    }

    public function getStoreReceiptDataValidSubscription()
    {
        return json_decode('{"status":0,"environment":"Production","receipt":{"receipt_type":"Production","adam_id":379968583,"app_item_id":379968583,"bundle_id":"com.busuu.english.app","application_version":"2","download_id":75007999904088,"version_external_identifier":818322555,"receipt_creation_date":"2016-08-17 11:03:53 Etc\/GMT","receipt_creation_date_ms":"1471431833000","receipt_creation_date_pst":"2016-08-17 04:03:53 America\/Los_Angeles","request_date":"2016-08-17 16:04:03 Etc\/GMT","request_date_ms":"1471449843432","request_date_pst":"2016-08-17 09:04:03 America\/Los_Angeles","original_purchase_date":"2015-08-06 17:57:23 Etc\/GMT","original_purchase_date_ms":"1438883843000","original_purchase_date_pst":"2015-08-06 10:57:23 America\/Los_Angeles","original_application_version":"1","in_app":[{"quantity":"1","product_id":"com.busuu.app.subs1monthoptionC.switzerland","transaction_id":"350000159445075","original_transaction_id":"350000159445075","purchase_date":"2016-08-17 11:03:52 Etc\/GMT","purchase_date_ms":"1471431832487","purchase_date_pst":"2016-08-17 04:03:52 America\/Los_Angeles","original_purchase_date":"2016-08-17 11:03:53 Etc\/GMT","original_purchase_date_ms":"1471431833000","original_purchase_date_pst":"2016-08-17 04:03:53 America\/Los_Angeles","expires_date":"2016-09-17 11:03:52 Etc\/GMT","expires_date_ms":"1474110232487","expires_date_pst":"2016-09-17 04:03:52 America\/Los_Angeles","web_order_line_item_id":"350000026263678","is_trial_period":"false"}]},"latest_receipt_info":[{"quantity":"1","product_id":"com.busuu.app.subs1monthoptionC.switzerland","transaction_id":"350000159445075","original_transaction_id":"350000159445075","purchase_date":"2016-08-17 11:03:52 Etc\/GMT","purchase_date_ms":"1471431832487","purchase_date_pst":"2016-08-17 04:03:52 America\/Los_Angeles","original_purchase_date":"2016-08-17 11:03:53 Etc\/GMT","original_purchase_date_ms":"1471431833000","original_purchase_date_pst":"2016-08-17 04:03:53 America\/Los_Angeles","expires_date":"2016-09-17 11:03:52 Etc\/GMT","expires_date_ms":"1474110232487","expires_date_pst":"2016-09-17 04:03:52 America\/Los_Angeles","web_order_line_item_id":"350000026263678","is_trial_period":"false"}],"latest_receipt":"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\/pn+\/8Jr9VterHNRSQhWicxDkMyOgQLQoJe2XLGhaWmHkBBoJiY5uB0Qc7AKXcVz0N92O9gt2Yge4+wHz+KO0NP6JlWB7+IDSSMCAwEAAaOCAdcwggHTMD8GCCsGAQUFBwEBBDMwMTAvBggrBgEFBQcwAYYjaHR0cDovL29jc3AuYXBwbGUuY29tL29jc3AwMy13d2RyMDQwHQYDVR0OBBYEFJGknPzEdrefoIr0TfWPNl3tKwSFMAwGA1UdEwEB\/wQCMAAwHwYDVR0jBBgwFoAUiCcXCam2GGCL7Ou69kdZxVJUo7cwggEeBgNVHSAEggEVMIIBETCCAQ0GCiqGSIb3Y2QFBgEwgf4wgcMGCCsGAQUFBwICMIG2DIGzUmVsaWFuY2Ugb24gdGhpcyBjZXJ0aWZpY2F0ZSBieSBhbnkgcGFydHkgYXNzdW1lcyBhY2NlcHRhbmNlIG9mIHRoZSB0aGVuIGFwcGxpY2FibGUgc3RhbmRhcmQgdGVybXMgYW5kIGNvbmRpdGlvbnMgb2YgdXNlLCBjZXJ0aWZpY2F0ZSBwb2xpY3kgYW5kIGNlcnRpZmljYXRpb24gcHJhY3RpY2Ugc3RhdGVtZW50cy4wNgYIKwYBBQUHAgEWKmh0dHA6Ly93d3cuYXBwbGUuY29tL2NlcnRpZmljYXRlYXV0aG9yaXR5LzAOBgNVHQ8BAf8EBAMCB4AwEAYKKoZIhvdjZAYLAQQCBQAwDQYJKoZIhvcNAQEFBQADggEBAA2mG9MuPeNbKwduQpZs0+iMQzCCX+Bc0Y2+vQ+9GvwlktuMhcOAWd\/j4tcuBRSsDdu2uP78NS58y60Xa45\/H+R3ubFnlbQTXqYZhnb4WiCV52OMD3P86O3GH66Z+GVIXKDgKDrAEDctuaAEOR9zucgF\/fLefxoqKm4rAfygIFzZ630npjP49ZjgvkTbsUxn\/G4KT8niBqjSl\/OnjmtRolqEdWXRFgRi48Ff9Qipz2jZkgDJwYyz+I0AZLpYYMB8r491ymm5WyrWHWhumEL1TKc3GZvMOxx6GUPzo22\/SGAGDDaSK+zeGLUR2i0j0I78oGmcFxuegHs5R0UwYS\/HE6gwggQiMIIDCqADAgECAggB3rzEOW2gEDANBgkqhkiG9w0BAQUFADBiMQswCQYDVQQGEwJVUzETMBEGA1UEChMKQXBwbGUgSW5jLjEmMCQGA1UECxMdQXBwbGUgQ2VydGlmaWNhdGlvbiBBdXRob3JpdHkxFjAUBgNVBAMTDUFwcGxlIFJvb3QgQ0EwHhcNMTMwMjA3MjE0ODQ3WhcNMjMwMjA3MjE0ODQ3WjCBljELMAkGA1UEBhMCVVMxEzARBgNVBAoMCkFwcGxlIEluYy4xLDAqBgNVBAsMI0FwcGxlIFdvcmxkd2lkZSBEZXZlbG9wZXIgUmVsYXRpb25zMUQwQgYDVQQDDDtBcHBsZSBXb3JsZHdpZGUgRGV2ZWxvcGVyIFJlbGF0aW9ucyBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMo4VKbLVqrIJDlI6Yzu7F+4fyaRvDRTes58Y4Bhd2RepQcjtjn+UC0VVlhwLX7EbsFKhT4v8N6EGqFXya97GP9q+hUSSRUIGayq2yoy7ZZjaFIVPYyK7L9rGJXgA6wBfZcFZ84OhZU3au0Jtq5nzVFkn8Zc0bxXbmc1gHY2pIeBbjiP2CsVTnsl2Fq\/ToPBjdKT1RpxtWCcnTNOVfkSWAyGuBYNweV3RY1QSLorLeSUheHoxJ3GaKWwo\/xnfnC6AllLd0KRObn1zeFM78A7SIym5SFd\/Wpqu6cWNWDS5q3zRinJ6MOL6XnAamFnFbLw\/eVovGJfbs+Z3e8bY\/6SZasCAwEAAaOBpjCBozAdBgNVHQ4EFgQUiCcXCam2GGCL7Ou69kdZxVJUo7cwDwYDVR0TAQH\/BAUwAwEB\/zAfBgNVHSMEGDAWgBQr0GlHlHYJ\/vRrjS5ApvdHTX8IXjAuBgNVHR8EJzAlMCOgIaAfhh1odHRwOi8vY3JsLmFwcGxlLmNvbS9yb290LmNybDAOBgNVHQ8BAf8EBAMCAYYwEAYKKoZIhvdjZAYCAQQCBQAwDQYJKoZIhvcNAQEFBQADggEBAE\/P71m+LPWybC+P7hOHMugFNahui33JaQy52Re8dyzUZ+L9mm06WVzfgwG9sq4qYXKxr83DRTCPo4MNzh1HtPGTiqN0m6TDmHKHOz6vRQuSVLkyu5AYU2sKThC22R1QbCGAColOV4xrWzw9pv3e9w0jHQtKJoc\/upGSTKQZEhltV\/V6WId7aIrkhoxK6+JJFKql3VUAqa67SzCu4aCxvCmA5gl35b40ogHKf9ziCuY7uLvsumKV8wVjQYLNDzsdTJWk26v5yZXpT+RN5yaZgem8+bQp0gF6ZuEujPYhisX4eOGBrr\/TkJ2prfOv\/TgalmcwHFGlXOxxioK0bA8MFR8wggS7MIIDo6ADAgECAgECMA0GCSqGSIb3DQEBBQUAMGIxCzAJBgNVBAYTAlVTMRMwEQYDVQQKEwpBcHBsZSBJbmMuMSYwJAYDVQQLEx1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEWMBQGA1UEAxMNQXBwbGUgUm9vdCBDQTAeFw0wNjA0MjUyMTQwMzZaFw0zNTAyMDkyMTQwMzZaMGIxCzAJBgNVBAYTAlVTMRMwEQYDVQQKEwpBcHBsZSBJbmMuMSYwJAYDVQQLEx1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEWMBQGA1UEAxMNQXBwbGUgUm9vdCBDQTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAOSRqQkfkdseR1DrBe1eeYQt6zaiV0xV7IsZid75S2z1B6siMALoGD74UAnTf0GomPnRymacJGsR0KO75Bsqwx+VnnoMpEeLW9QWNzPLxA9NzhRp0ckZcvVdDtV\/X5vyJQO6VY9NXQ3xZDUjFUsVWR2zlPf2nJ7PULrBWFBnjwi0IPfLrCwgb3C2PwEwjLdDzw+dPfMrSSgayP7OtbkO2V4c1ss9tTqt9A8OAJILsSEWLnTVPA3bYharo3GSR1NVwa8vQbP4++NwzeajTEV+H0xrUJZBicR0YgsQg0GHM4qBsTBY7FoEMoxos48d3mVz\/2deZbxJ2HafMxRloXeUyS0CAwEAAaOCAXowggF2MA4GA1UdDwEB\/wQEAwIBBjAPBgNVHRMBAf8EBTADAQH\/MB0GA1UdDgQWBBQr0GlHlHYJ\/vRrjS5ApvdHTX8IXjAfBgNVHSMEGDAWgBQr0GlHlHYJ\/vRrjS5ApvdHTX8IXjCCAREGA1UdIASCAQgwggEEMIIBAAYJKoZIhvdjZAUBMIHyMCoGCCsGAQUFBwIBFh5odHRwczovL3d3dy5hcHBsZS5jb20vYXBwbGVjYS8wgcMGCCsGAQUFBwICMIG2GoGzUmVsaWFuY2Ugb24gdGhpcyBjZXJ0aWZpY2F0ZSBieSBhbnkgcGFydHkgYXNzdW1lcyBhY2NlcHRhbmNlIG9mIHRoZSB0aGVuIGFwcGxpY2FibGUgc3RhbmRhcmQgdGVybXMgYW5kIGNvbmRpdGlvbnMgb2YgdXNlLCBjZXJ0aWZpY2F0ZSBwb2xpY3kgYW5kIGNlcnRpZmljYXRpb24gcHJhY3RpY2Ugc3RhdGVtZW50cy4wDQYJKoZIhvcNAQEFBQADggEBAFw2mUwteLftjJvc83eb8nbSdzBPwR+Fg4UbmT1HN\/Kpm0COLNSxkBLYvvRzm+7SZA\/LeU802KI++Xj\/a8gH7H05g4tTINM4xLG\/mk8Ka\/8r\/FmnBQl8F0BWER5007eLIztHo9VvJOLr0bdw3w9F4SfK8W147ee1Fxeo3H4iNcol1dkP1mvUoiQjEfehrI9zgWDGG1sJL5Ky+ERI8GA4nhX1PSZnIIozavcNgs\/e66Mv+VNqW2TAYzN39zoHLFbr2g8hDtq6cxlPtdk2f8GHVdmnmbkyQvvY1XGefqFStxu9k0IkEirHDx22TZxeY8hLgBdQqorV2uT80AkHN7B1dSExggHLMIIBxwIBATCBozCBljELMAkGA1UEBhMCVVMxEzARBgNVBAoMCkFwcGxlIEluYy4xLDAqBgNVBAsMI0FwcGxlIFdvcmxkd2lkZSBEZXZlbG9wZXIgUmVsYXRpb25zMUQwQgYDVQQDDDtBcHBsZSBXb3JsZHdpZGUgRGV2ZWxvcGVyIFJlbGF0aW9ucyBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eQIIDutXh+eeCY0wCQYFKw4DAhoFADANBgkqhkiG9w0BAQEFAASCAQBkIFbY26MH3zC6s769iRB\/N22EN6uIJ08p5Jv7PWXAyQ+mLzpO+p+VOezbcn9Gft9tLatKaeKQTkZY8nnSxJrciU4c9V0Gm26AYC4rLV0LVHHf+e3mN5TAu\/S6ypCWyCF2Bu+6brkAtDq1TR4q9dss4hUwJ\/w6ScczLOooOjiG3HGQNfO\/YvuqDkiPlJFPn+g93RvfAla2ac0QE1u0WFGo6yATbXbMPmT1\/ksWMxfWeT3NHMxLwbUiAHAjT+ungU8ZKBY5jtJLlCfpgML8HiGkSADMlDUdotx8Llwmb0V3Tt5oXThFSwN+qFV2zbj2IadRS21kbjveCFNFcTjhUGYw"}', true);
    }

    /**
     * Returns a store receipt array with multiple subscriptions (within 'in_app' and 'latest_receipt_info')
     */
    public function getStoreReceiptMultipleSubscriptions()
    {
        return json_decode('{"status":0,"environment":"Production","receipt":{"receipt_type":"Production","adam_id":379973213,"app_item_id":379973213,"bundle_id":"com.busuu.english.app","application_version":"2","download_id":75007999904088,"version_external_identifier":818322555,"receipt_creation_date":"2015-10-13 10:38:22 Etc/GMT","receipt_creation_date_ms":"1444732702000","receipt_creation_date_pst":"2015-10-13 03:38:22 America/Los_Angeles","request_date":"2018-01-05 11:42:07 Etc/GMT","request_date_ms":"1515152527633","request_date_pst":"2018-01-05 03:42:07 America/Los_Angeles","original_purchase_date":"2015-07-09 11:00:20 Etc/GMT","original_purchase_date_ms":"1436439620075","original_purchase_date_pst":"2015-07-09 04:00:20 America/Los_Angeles","original_application_version":"1","in_app":[{"quantity":"1","product_id":"com.busuu.app.subs1monthoptionC.switzerland","transaction_id":"140000164972207","original_transaction_id":"140000164971107","purchase_date":"015-10-13 10:38:17 Etc/GMT","purchase_date_ms":"1444732697000","purchase_date_pst":"2015-10-13 03:38:17 America/Los_Angeles","original_purchase_date":"2015-10-13 10:38:22 Etc/GMT","original_purchase_date_ms":"1444732702000","original_purchase_date_pst":"2015-10-13 03:38:22 America/Los_Angeles","expires_date":"2015-11-13 11:38:17 Etc/GMT","expires_date_ms":"1447414697000","expires_date_pst":"2015-11-13 03:38:17 America/Los_Angeles","web_order_line_item_id":"140000019536111","is_trial_period":"false"}]},"latest_receipt_info":[{"quantity":"1","product_id":"com.busuu.app.subs1monthoptionC.switzerland","transaction_id":"140000164972207","original_transaction_id":"140000164971107","purchase_date":"2015-10-13 10:38:17 Etc/GMT","purchase_date_ms":"1444732697000","purchase_date_pst":"2015-10-13 03:38:17 America/Los_Angeles","original_purchase_date":"2015-10-13 10:38:22 Etc/GMT","original_purchase_date_ms":"1444732702000","original_purchase_date_pst":"2015-10-13 03:38:22 America/Los_Angeles","expires_date":"2015-11-13 11:38:17 Etc/GMT","expires_date_ms":"1447414697000","expires_date_pst":"2015-11-13 03:38:17 America/Los_Angeles","web_order_line_item_id":"350000026263110","is_trial_period":"false"},{"quantity":"1","product_id":"com.busuu.app.subs1monthoptionC.switzerland","transaction_id":"140000170968732","original_transaction_id":"140000164971107","purchase_date":"2015-11-13 11:38:17 Etc/GMT","purchase_date_ms":"1447414697000","purchase_date_pst":"015-11-13 03:38:17 America/Los_Angeles","original_purchase_date":"2015-10-13 10:38:22 Etc/GMT","original_purchase_date_ms":"1444732702000","original_purchase_date_pst":"2015-10-13 03:38:22 America/Los_Angeles","expires_date":"2015-12-13 11:38:17 Etc/GMT","expires_date_ms":"1450006697000","expires_date_pst":"2015-12-13 03:38:17 America/Los_Angeles","web_order_line_item_id":"140000019536111","is_trial_period":"false"}],"latest_receipt":"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\/pn+\/8Jr9VterHNRSQhWicxDkMyOgQLQoJe2XLGhaWmHkBBoJiY5uB0Qc7AKXcVz0N92O9gt2Yge4+wHz+KO0NP6JlWB7+IDSSMCAwEAAaOCAdcwggHTMD8GCCsGAQUFBwEBBDMwMTAvBggrBgEFBQcwAYYjaHR0cDovL29jc3AuYXBwbGUuY29tL29jc3AwMy13d2RyMDQwHQYDVR0OBBYEFJGknPzEdrefoIr0TfWPNl3tKwSFMAwGA1UdEwEB\/wQCMAAwHwYDVR0jBBgwFoAUiCcXCam2GGCL7Ou69kdZxVJUo7cwggEeBgNVHSAEggEVMIIBETCCAQ0GCiqGSIb3Y2QFBgEwgf4wgcMGCCsGAQUFBwICMIG2DIGzUmVsaWFuY2Ugb24gdGhpcyBjZXJ0aWZpY2F0ZSBieSBhbnkgcGFydHkgYXNzdW1lcyBhY2NlcHRhbmNlIG9mIHRoZSB0aGVuIGFwcGxpY2FibGUgc3RhbmRhcmQgdGVybXMgYW5kIGNvbmRpdGlvbnMgb2YgdXNlLCBjZXJ0aWZpY2F0ZSBwb2xpY3kgYW5kIGNlcnRpZmljYXRpb24gcHJhY3RpY2Ugc3RhdGVtZW50cy4wNgYIKwYBBQUHAgEWKmh0dHA6Ly93d3cuYXBwbGUuY29tL2NlcnRpZmljYXRlYXV0aG9yaXR5LzAOBgNVHQ8BAf8EBAMCB4AwEAYKKoZIhvdjZAYLAQQCBQAwDQYJKoZIhvcNAQEFBQADggEBAA2mG9MuPeNbKwduQpZs0+iMQzCCX+Bc0Y2+vQ+9GvwlktuMhcOAWd\/j4tcuBRSsDdu2uP78NS58y60Xa45\/H+R3ubFnlbQTXqYZhnb4WiCV52OMD3P86O3GH66Z+GVIXKDgKDrAEDctuaAEOR9zucgF\/fLefxoqKm4rAfygIFzZ630npjP49ZjgvkTbsUxn\/G4KT8niBqjSl\/OnjmtRolqEdWXRFgRi48Ff9Qipz2jZkgDJwYyz+I0AZLpYYMB8r491ymm5WyrWHWhumEL1TKc3GZvMOxx6GUPzo22\/SGAGDDaSK+zeGLUR2i0j0I78oGmcFxuegHs5R0UwYS\/HE6gwggQiMIIDCqADAgECAggB3rzEOW2gEDANBgkqhkiG9w0BAQUFADBiMQswCQYDVQQGEwJVUzETMBEGA1UEChMKQXBwbGUgSW5jLjEmMCQGA1UECxMdQXBwbGUgQ2VydGlmaWNhdGlvbiBBdXRob3JpdHkxFjAUBgNVBAMTDUFwcGxlIFJvb3QgQ0EwHhcNMTMwMjA3MjE0ODQ3WhcNMjMwMjA3MjE0ODQ3WjCBljELMAkGA1UEBhMCVVMxEzARBgNVBAoMCkFwcGxlIEluYy4xLDAqBgNVBAsMI0FwcGxlIFdvcmxkd2lkZSBEZXZlbG9wZXIgUmVsYXRpb25zMUQwQgYDVQQDDDtBcHBsZSBXb3JsZHdpZGUgRGV2ZWxvcGVyIFJlbGF0aW9ucyBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMo4VKbLVqrIJDlI6Yzu7F+4fyaRvDRTes58Y4Bhd2RepQcjtjn+UC0VVlhwLX7EbsFKhT4v8N6EGqFXya97GP9q+hUSSRUIGayq2yoy7ZZjaFIVPYyK7L9rGJXgA6wBfZcFZ84OhZU3au0Jtq5nzVFkn8Zc0bxXbmc1gHY2pIeBbjiP2CsVTnsl2Fq\/ToPBjdKT1RpxtWCcnTNOVfkSWAyGuBYNweV3RY1QSLorLeSUheHoxJ3GaKWwo\/xnfnC6AllLd0KRObn1zeFM78A7SIym5SFd\/Wpqu6cWNWDS5q3zRinJ6MOL6XnAamFnFbLw\/eVovGJfbs+Z3e8bY\/6SZasCAwEAAaOBpjCBozAdBgNVHQ4EFgQUiCcXCam2GGCL7Ou69kdZxVJUo7cwDwYDVR0TAQH\/BAUwAwEB\/zAfBgNVHSMEGDAWgBQr0GlHlHYJ\/vRrjS5ApvdHTX8IXjAuBgNVHR8EJzAlMCOgIaAfhh1odHRwOi8vY3JsLmFwcGxlLmNvbS9yb290LmNybDAOBgNVHQ8BAf8EBAMCAYYwEAYKKoZIhvdjZAYCAQQCBQAwDQYJKoZIhvcNAQEFBQADggEBAE\/P71m+LPWybC+P7hOHMugFNahui33JaQy52Re8dyzUZ+L9mm06WVzfgwG9sq4qYXKxr83DRTCPo4MNzh1HtPGTiqN0m6TDmHKHOz6vRQuSVLkyu5AYU2sKThC22R1QbCGAColOV4xrWzw9pv3e9w0jHQtKJoc\/upGSTKQZEhltV\/V6WId7aIrkhoxK6+JJFKql3VUAqa67SzCu4aCxvCmA5gl35b40ogHKf9ziCuY7uLvsumKV8wVjQYLNDzsdTJWk26v5yZXpT+RN5yaZgem8+bQp0gF6ZuEujPYhisX4eOGBrr\/TkJ2prfOv\/TgalmcwHFGlXOxxioK0bA8MFR8wggS7MIIDo6ADAgECAgECMA0GCSqGSIb3DQEBBQUAMGIxCzAJBgNVBAYTAlVTMRMwEQYDVQQKEwpBcHBsZSBJbmMuMSYwJAYDVQQLEx1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEWMBQGA1UEAxMNQXBwbGUgUm9vdCBDQTAeFw0wNjA0MjUyMTQwMzZaFw0zNTAyMDkyMTQwMzZaMGIxCzAJBgNVBAYTAlVTMRMwEQYDVQQKEwpBcHBsZSBJbmMuMSYwJAYDVQQLEx1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEWMBQGA1UEAxMNQXBwbGUgUm9vdCBDQTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAOSRqQkfkdseR1DrBe1eeYQt6zaiV0xV7IsZid75S2z1B6siMALoGD74UAnTf0GomPnRymacJGsR0KO75Bsqwx+VnnoMpEeLW9QWNzPLxA9NzhRp0ckZcvVdDtV\/X5vyJQO6VY9NXQ3xZDUjFUsVWR2zlPf2nJ7PULrBWFBnjwi0IPfLrCwgb3C2PwEwjLdDzw+dPfMrSSgayP7OtbkO2V4c1ss9tTqt9A8OAJILsSEWLnTVPA3bYharo3GSR1NVwa8vQbP4++NwzeajTEV+H0xrUJZBicR0YgsQg0GHM4qBsTBY7FoEMoxos48d3mVz\/2deZbxJ2HafMxRloXeUyS0CAwEAAaOCAXowggF2MA4GA1UdDwEB\/wQEAwIBBjAPBgNVHRMBAf8EBTADAQH\/MB0GA1UdDgQWBBQr0GlHlHYJ\/vRrjS5ApvdHTX8IXjAfBgNVHSMEGDAWgBQr0GlHlHYJ\/vRrjS5ApvdHTX8IXjCCAREGA1UdIASCAQgwggEEMIIBAAYJKoZIhvdjZAUBMIHyMCoGCCsGAQUFBwIBFh5odHRwczovL3d3dy5hcHBsZS5jb20vYXBwbGVjYS8wgcMGCCsGAQUFBwICMIG2GoGzUmVsaWFuY2Ugb24gdGhpcyBjZXJ0aWZpY2F0ZSBieSBhbnkgcGFydHkgYXNzdW1lcyBhY2NlcHRhbmNlIG9mIHRoZSB0aGVuIGFwcGxpY2FibGUgc3RhbmRhcmQgdGVybXMgYW5kIGNvbmRpdGlvbnMgb2YgdXNlLCBjZXJ0aWZpY2F0ZSBwb2xpY3kgYW5kIGNlcnRpZmljYXRpb24gcHJhY3RpY2Ugc3RhdGVtZW50cy4wDQYJKoZIhvcNAQEFBQADggEBAFw2mUwteLftjJvc83eb8nbSdzBPwR+Fg4UbmT1HN\/Kpm0COLNSxkBLYvvRzm+7SZA\/LeU802KI++Xj\/a8gH7H05g4tTINM4xLG\/mk8Ka\/8r\/FmnBQl8F0BWER5007eLIztHo9VvJOLr0bdw3w9F4SfK8W147ee1Fxeo3H4iNcol1dkP1mvUoiQjEfehrI9zgWDGG1sJL5Ky+ERI8GA4nhX1PSZnIIozavcNgs\/e66Mv+VNqW2TAYzN39zoHLFbr2g8hDtq6cxlPtdk2f8GHVdmnmbkyQvvY1XGefqFStxu9k0IkEirHDx22TZxeY8hLgBdQqorV2uT80AkHN7B1dSExggHLMIIBxwIBATCBozCBljELMAkGA1UEBhMCVVMxEzARBgNVBAoMCkFwcGxlIEluYy4xLDAqBgNVBAsMI0FwcGxlIFdvcmxkd2lkZSBEZXZlbG9wZXIgUmVsYXRpb25zMUQwQgYDVQQDDDtBcHBsZSBXb3JsZHdpZGUgRGV2ZWxvcGVyIFJlbGF0aW9ucyBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eQIIDutXh+eeCY0wCQYFKw4DAhoFADANBgkqhkiG9w0BAQEFAASCAQBkIFbY26MH3zC6s769iRB\/N22EN6uIJ08p5Jv7PWXAyQ+mLzpO+p+VOezbcn9Gft9tLatKaeKQTkZY8nnSxJrciU4c9V0Gm26AYC4rLV0LVHHf+e3mN5TAu\/S6ypCWyCF2Bu+6brkAtDq1TR4q9dss4hUwJ\/w6ScczLOooOjiG3HGQNfO\/YvuqDkiPlJFPn+g93RvfAla2ac0QE1u0WFGo6yATbXbMPmT1\/ksWMxfWeT3NHMxLwbUiAHAjT+ungU8ZKBY5jtJLlCfpgML8HiGkSADMlDUdotx8Llwmb0V3Tt5oXThFSwN+qFV2zbj2IadRS21kbjveCFNFcTjhUGYw"}', true);
    }

    public function getStoreReceiptDataNoPurchase()
    {
        return json_decode('{"status":0,"environment":"Production","receipt":{"receipt_type":"Production","adam_id":372967583,"app_item_id":372967583,"bundle_id":"com.busuu.english.app","application_version":"2","download_id":83018699139059,"version_external_identifier":818532555,"receipt_creation_date":"2016-08-18 09:00:45 Etc\/GMT","receipt_creation_date_ms":"1471510845000","receipt_creation_date_pst":"2016-08-18 02:00:45 America\/Los_Angeles","request_date":"2016-08-18 10:25:07 Etc\/GMT","request_date_ms":"1471515907507","request_date_pst":"2016-08-18 03:25:07 America\/Los_Angeles","original_purchase_date":"2016-08-18 09:00:45 Etc\/GMT","original_purchase_date_ms":"1471510845000","original_purchase_date_pst":"2016-08-18 02:00:45 America\/Los_Angeles","original_application_version":"2","in_app":[]}}', true);
    }
}
