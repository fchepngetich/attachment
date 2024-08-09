<?php 
namespace App\Libraries;

class CIAuth{


        public static function CIAuth($result, $userType) {
            $session = session();
            $array = ['logged_in' => true, 'user_type' => $userType];
            $session->set('userdata', $result);
            $session->set($array);
        }
    
        public static function id() {
            $session = session();
            if ($session->has('logged_in')) {
                if ($session->has('userdata')) {
                    return $session->get('userdata')['id'];
                }
            }
            return null;
        }
    
        public static function fullName() {
            $session = session();
            if ($session->has('logged_in')) {
                if ($session->has('userdata')) {
                    $userType = $session->get('user_type');
                    if ($userType == 'lecturer') {
                        return $session->get('userdata')['full_name'];
                    } else {
                        return $session->get('userdata')['name'] . ' ' . $session->get('userdata')['name'];
                    }
                }
            }
            return null;
        }
    
        public static function check() {
            $session = session();
            return $session->has('logged_in');
        }
    
        public static function forget() {
            $session = session();
            $session->remove('logged_in');
            $session->remove('userdata');
            $session->remove('user_type');
        }
    
        public static function user() {
            $session = session();
            if ($session->has('logged_in')) {
                if ($session->has('userdata')) {
                    return $session->get('userdata');
                }
            }
            return null;
        }
    
        public static function userType() {
            $session = session();
            if ($session->has('logged_in')) {
                return $session->get('user_type');
            }
            return null;
        }
    
    
    // public static function CIAuth($result){
    //     $session = session();
    //     $array = ['logged_in'=>true];
    //     $userdata = $result;
    //     $session->set('userdata',$userdata);
    //     $session->set($array);

    // }
    // public static function id(){
    //     $session = session();
    //     if ($session->has('logged_in')){
    //         if($session->has('userdata')){
    //             return $session->get('userdata')['id'];
    //         }else{
    //             return null;
    //         }
    //     }else{
    //         return null;
    //     }
    // }
    // public static function StudentName(){
    //     $session = session();
    //     if ($session->has('logged_in')){
    //         if($session->has('userdata')){
    //             return $session->get('userdata')['name'];
    //         }else{
    //             return null;
    //         }
    //     }else{
    //         return null;
    //     }
    // }
    // public static function fullName(){
    //     $session = session();
    //     if ($session->has('logged_in')){
    //         if($session->has('userdata')){
    //             return $session->get('userdata')['full_name'];
    //         }else{
    //             return null;
    //         }
    //     }else{
    //         return null;
    //     }
    // }
    // public static function check(){
    //     $session = session();
    //     return $session->has('logged_in');
    // }
    // public static function forget(){
    //     $session = session();
    //     $session->remove('logged_in');
    //     $session->remove('userdata');
    // }
    // public static function user(){
    //     $session= session();
    //     if($session->has('logged_in')){
    //         if($session->has('userdata')){
    //         return $session->get('userdata');
    //         }else{
    //             return null;
    //         }

    //     }else{
    //         return null;
    //     }
    // }
 
}