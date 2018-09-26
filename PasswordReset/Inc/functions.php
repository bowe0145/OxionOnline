<?php
    
    if(!defined("OxionUserCP")) exit;

    class Functions
    {
		public static function ClassImage($nClass){
			if($nClass == 1 || $nClass == 2 || $nClass == 3 || $nClass == 4 || $nClass == 5){
				return "F-Fighter.png";	
			}
			elseif($nClass == 6 || $nClass == 7 || $nClass == 8 || $nClass == 9 || $nClass == 10){
				return "C-Cleric.png";	
			}
			elseif($nClass == 11 || $nClass == 12 || $nClass == 13 || $nClass == 14 || $nClass == 15){
				return "A-Archer.png";	
			}
			elseif($nClass == 16 || $nClass == 17 || $nClass == 18 || $nClass == 19 || $nClass == 20){
				return "M-Mage.png";	
			}
			elseif($nClass == 21 || $nClass == 22 || $nClass == 23 || $nClass == 24 || $nClass == 25){
				return "T-Trickster.png";	
			}
			else{
				return "F-Fighter.png";	
			}	
		}
		
		public static function NumToName($nClass){
			
			switch($nClass){
				case 1:
					return "Fighter";
					break;
				case 2:
					return "Clever Figter";
					break;
				case 3:
					return "Warrior";
					break;
				case 4:
					return "Gladiator";
					break;
				case 5:
					return "Knight";
					break;
				case 6:
					return "Cleric";
					break;
				case 7:
					return "High Cleric";
					break;
				case 8:
					return "Paladin";
					break;
				case 9:
					return "Holy Knight";
					break;
				case 10:
					return "Guardian";
					break;
				case 11:
					return "Archer";
					break;
				case 12:
					return "Hawk Archer";
					break;
				case 13:
					return "Scout";
					break;
				case 14:
					return "Sharp Shooter";
					break;
				case 15:
					return "Ranger";
					break;
				case 16:
					return "Mage";
					break;
				case 17:
					return "Wiz Mage";
					break;
				case 18:
					return "Enchanter";
					break;
				case 19:
					return "Warlock";
					break;
				case 20:
					return "Wizard";
					break;
				case 21:
					return "Trickster";
					break;
				case 22:
					return "Gambit";
					break;
				case 23:
					return "Renegade";
					break;
				case 24:
					return "Spectre";
					break;
				case 25:
					return "Reaper";
				default:
					return $nClass;
			}	
		}
		
        public static function Error($type){
            echo $type;
            exit;
        }

        public static function SetSession($nEMID, $username){
            $_SESSION['nEMID'] = $nEMID;
            $_SESSION['sUsername'] = $username; 
        }

        public static function LogOut(){
            session_destroy();
        }

        public static function Redirect($url){
            header("Location: ".$url);
        }
    }
?>