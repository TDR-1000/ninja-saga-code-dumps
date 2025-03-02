package ninjasaga 
{
    public class Account extends Object
    {
        public function Account()
        {
            super();
            return;
        }

        public static function getAccountSessionKey():String
        {
            return account_session_key;
        }

        public static function getAccountBalance():uint
        {
            return account_balance;
        }

        public static function getAccountTypeNoVerify():uint
        {
            return account_type;
        }

        public static function setupAccount(arg1:Array, arg2:String):Boolean
        {
            var loc1:*;
            loc1 = undefined;
            loc1 = undefined;
            loc1 = undefined;
            loc1 = undefined;
            loc1 = undefined;
            loc1 = null;
            account_session_key = arg1[3];
            if (Central.main)
            {
                loc1 = arg1[0] + "|" + arg1[1] + "|" + arg1[2];
                if (Central.main.getHash(loc1) != arg2)
                {
                    return false;
                }
            }
            if (arg1[0] > 0)
            {
                account_id = arg1[0];
                accountTypeHash = Sha1Encrypt.encrypt(String(arg1[1]));
                account_type = arg1[1];
                account_balance = arg1[2];
                return true;
            }
            return false;
        }

        public static function getAccountType():uint
        {
            if (accountTypeHash == Sha1Encrypt.encrypt(String(account_type)))
            {
                return account_type;
            }
            Out.data("Account", "account type mismatch");
            Central.main.submitData();
            return 1;
        }

        public static function getAccountId():uint
        {
            return account_id;
        }

        public static function set balance(arg1:int):void
        {
            account_balance = arg1;
            return;
        }

        public static const FREE:uint=1;

        public static const PREMIUM:uint=2;

        private static var account_session_key:String;

        private static var account_balance:int;

        private static var account_id:uint;

        private static var account_type:uint;

        private static var accountTypeHash:String;
    }
}
