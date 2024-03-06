<?php

namespace App\Traits;

trait PhoneNumberFormater
{
    public function formatPhoneNumber($phoneNumber): string
    {
        // Remove non-numeric characters from the phone number
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Check if it's a mobile or landline number and apply the appropriate format
        if (strlen($phoneNumber) == 11) {
            // Format as (XX) 9XXXX-XXXX for mobile numbers
            return sprintf(
                '(%s) %s-%s',
                substr($phoneNumber, 0, 2),
                substr($phoneNumber, 2, 5),
                substr($phoneNumber, 7)
            );
        } elseif (strlen($phoneNumber) == 10) {
            // Format as (XX) XXXX-XXXX for landline numbers
            return sprintf(
                '(%s) %s-%s',
                substr($phoneNumber, 0, 2),
                substr($phoneNumber, 2, 4),
                substr($phoneNumber, 6)
            );
        }

        // Return the original number if it doesn't match expected lengths
        return $phoneNumber;
    }
}
