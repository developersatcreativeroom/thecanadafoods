<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
              [
                "name" => "Afghanistan",
                "local" => "Afghanistan (l')",
                "code" => "AF",
                "status" => true
              ],
              [
                "name" => "Åland Islands",
                "local" => "Åland(les Îles)",
                "code" => "AX",
                "status" => true
              ],
              [
                "name" => "Albania",
                "local" => "Albanie (l')",
                "code" => "AL",
                "status" => true
              ],
              [
                "name" => "Algeria",
                "local" => "Algérie (l')",
                "code" => "DZ",
                "status" => true
              ],
              [
                "name" => "American Samoa",
                "local" => "Samoa américaines (les)",
                "code" => "AS",
                "status" => true
              ],
              [
                "name" => "Andorra",
                "local" => "Andorre (l')",
                "code" => "AD",
                "status" => true
              ],
              [
                "name" => "Angola",
                "local" => "Angola (l')",
                "code" => "AO",
                "status" => true
              ],
              [
                "name" => "Anguilla",
                "local" => "Anguilla",
                "code" => "AI",
                "status" => true
              ],
              [
                "name" => "Antarctica",
                "local" => "Antarctique (l')",
                "code" => "AQ",
                "status" => true
              ],
              [
                "name" => "Antigua and Barbuda",
                "local" => "Antigua-et-Barbuda",
                "code" => "AG",
                "status" => true
              ],
              [
                "name" => "Argentina",
                "local" => "Argentine (l')",
                "code" => "AR",
                "status" => true
              ],
              [
                "name" => "Armenia",
                "local" => "Arménie (l')",
                "code" => "AM",
                "status" => true
              ],
              [
                "name" => "Aruba",
                "local" => "Aruba",
                "code" => "AW",
                "status" => true
              ],
              [
                "name" => "Australia",
                "local" => "Australie (l')",
                "code" => "AU",
                "status" => true
              ],
              [
                "name" => "Austria",
                "local" => "Autriche (l')",
                "code" => "AT",
                "status" => true
              ],
              [
                "name" => "Azerbaijan",
                "local" => "Azerbaïdjan (l')",
                "code" => "AZ",
                "status" => true
              ],
              [
                "name" => "Bahamas (the)",
                "local" => "Bahamas (les)",
                "code" => "BS",
                "status" => true
              ],
              [
                "name" => "Bahrain",
                "local" => "Bahreïn",
                "code" => "BH",
                "status" => true
              ],
              [
                "name" => "Bangladesh",
                "local" => "Bangladesh (le)",
                "code" => "BD",
                "status" => true
              ],
              [
                "name" => "Barbados",
                "local" => "Barbade (la)",
                "code" => "BB",
                "status" => true
              ],
              [
                "name" => "Belarus",
                "local" => "Bélarus (le)",
                "code" => "BY",
                "status" => true
              ],
              [
                "name" => "Belgium",
                "local" => "Belgique (la)",
                "code" => "BE",
                "status" => true
              ],
              [
                "name" => "Belize",
                "local" => "Belize (le)",
                "code" => "BZ",
                "status" => true
              ],
              [
                "name" => "Benin",
                "local" => "Bénin (le)",
                "code" => "BJ",
                "status" => true
              ],
              [
                "name" => "Bermuda",
                "local" => "Bermudes (les)",
                "code" => "BM",
                "status" => true
              ],
              [
                "name" => "Bhutan",
                "local" => "Bhoutan (le)",
                "code" => "BT",
                "status" => true
              ],
              [
                "name" => "Bolivia (Plurinational State of)",
                "local" => "Bolivie (État plurinational de)",
                "code" => "BO",
                "status" => true
              ],
              [
                "name" => "Bonaire, Sint Eustatius and Saba",
                "local" => "Bonaire, Saint-Eustache et Saba",
                "code" => "BQ",
                "status" => true
              ],
              [
                "name" => "Bosnia and Herzegovina",
                "local" => "Bosnie-Herzégovine (la)",
                "code" => "BA",
                "status" => true
              ],
              [
                "name" => "Botswana",
                "local" => "Botswana (le)",
                "code" => "BW",
                "status" => true
              ],
              [
                "name" => "Bouvet Island",
                "local" => "Bouvet (l'Île)",
                "code" => "BV",
                "status" => true
              ],
              [
                "name" => "Brazil",
                "local" => "Brésil (le)",
                "code" => "BR",
                "status" => true
              ],
              [
                "name" => "British Indian Ocean Territory (the)",
                "local" => "Indien (le Territoire britannique de l'océan)",
                "code" => "IO",
                "status" => true
              ],
              [
                "name" => "Brunei Darussalam",
                "local" => "Brunéi Darussalam (le)",
                "code" => "BN",
                "status" => true
              ],
              [
                "name" => "Bulgaria",
                "local" => "Bulgarie (la)",
                "code" => "BG",
                "status" => true
              ],
              [
                "name" => "Burkina Faso",
                "local" => "Burkina Faso (le)",
                "code" => "BF",
                "status" => true
              ],
              [
                "name" => "Burundi",
                "local" => "Burundi (le)",
                "code" => "BI",
                "status" => true
              ],
              [
                "name" => "Cabo Verde",
                "local" => "Cabo Verde",
                "code" => "CV",
                "status" => true
              ],
              [
                "name" => "Cambodia",
                "local" => "Cambodge (le)",
                "code" => "KH",
                "status" => true
              ],
              [
                "name" => "Cameroon",
                "local" => "Cameroun (le)",
                "code" => "CM",
                "status" => true
              ],
              [
                "name" => "Canada",
                "local" => "Canada (le)",
                "code" => "CA",
                "status" => true
              ],
              [
                "name" => "Cayman Islands (the)",
                "local" => "Caïmans (les Îles)",
                "code" => "KY",
                "status" => true
              ],
              [
                "name" => "Central African Republic (the)",
                "local" => "République centrafricaine (la)",
                "code" => "CF",
                "status" => true
              ],
              [
                "name" => "Chad",
                "local" => "Tchad (le)",
                "code" => "TD",
                "status" => true
              ],
              [
                "name" => "Chile",
                "local" => "Chili (le)",
                "code" => "CL",
                "status" => true
              ],
              [
                "name" => "China",
                "local" => "Chine (la)",
                "code" => "CN",
                "status" => true
              ],
              [
                "name" => "Christmas Island",
                "local" => "Christmas (l'Île)",
                "code" => "CX",
                "status" => true
              ],
              [
                "name" => "Cocos (Keeling) Islands (the)",
                "local" => "Cocos (les Îles)/ Keeling (les Îles)",
                "code" => "CC",
                "status" => true
              ],
              [
                "name" => "Colombia",
                "local" => "Colombie (la)",
                "code" => "CO",
                "status" => true
              ],
              [
                "name" => "Comoros (the)",
                "local" => "Comores (les)",
                "code" => "KM",
                "status" => true
              ],
              [
                "name" => "Democratic Republic of the Congo",
                "local" => "Congo (la République démocratique du)",
                "code" => "CD",
                "status" => true
              ],
              [
                "name" => "Republic of the Congo",
                "local" => "Congo (le)",
                "code" => "CG",
                "status" => true
              ],
              [
                "name" => "Cook Islands (the)",
                "local" => "Cook (les Îles)",
                "code" => "CK",
                "status" => true
              ],
              [
                "name" => "Costa Rica",
                "local" => "Costa Rica (le)",
                "code" => "CR",
                "status" => true
              ],
              [
                "name" => "Côte d'Ivoire",
                "local" => "Côte d'Ivoire (la)",
                "code" => "CI",
                "status" => true
              ],
              [
                "name" => "Croatia",
                "local" => "Croatie (la)",
                "code" => "HR",
                "status" => true
              ],
              [
                "name" => "Cuba",
                "local" => "Cuba",
                "code" => "CU",
                "status" => true
              ],
              [
                "name" => "Curaçao",
                "local" => "Curaçao",
                "code" => "CW",
                "status" => true
              ],
              [
                "name" => "Cyprus",
                "local" => "Chypre",
                "code" => "CY",
                "status" => true
              ],
              [
                "name" => "Czech Republic (the)",
                "local" => "tchèque (la République)",
                "code" => "CZ",
                "status" => true
              ],
              [
                "name" => "Denmark",
                "local" => "Danemark (le)",
                "code" => "DK",
                "status" => true
              ],
              [
                "name" => "Djibouti",
                "local" => "Djibouti",
                "code" => "DJ",
                "status" => true
              ],
              [
                "name" => "Dominica",
                "local" => "Dominique (la)",
                "code" => "DM",
                "status" => true
              ],
              [
                "name" => "Dominican Republic (the)",
                "local" => "dominicaine (la République)",
                "code" => "DO",
                "status" => true
              ],
              [
                "name" => "East Timor",
                "local" => "East Timor",
                "code" => "TL",
                "status" => true
              ],
              [
                "name" => "Ecuador",
                "local" => "Équateur (l')",
                "code" => "EC",
                "status" => true
              ],
              [
                "name" => "Egypt",
                "local" => "Égypte (l')",
                "code" => "EG",
                "status" => true
              ],
              [
                "name" => "El Salvador",
                "local" => "El Salvador",
                "code" => "SV",
                "status" => true
              ],
              [
                "name" => "Equatorial Guinea",
                "local" => "Guinée équatoriale (la)",
                "code" => "GQ",
                "status" => true
              ],
              [
                "name" => "Eritrea",
                "local" => "Érythrée (l')",
                "code" => "ER",
                "status" => true
              ],
              [
                "name" => "Estonia",
                "local" => "Estonie (l')",
                "code" => "EE",
                "status" => true
              ],
              [
                "name" => "Ethiopia",
                "local" => "Éthiopie (l')",
                "code" => "ET",
                "status" => true
              ],
              [
                "name" => "Falkland Islands (the) [Malvinas]",
                "local" => "Falkland (les Îles)/Malouines (les Îles)",
                "code" => "FK",
                "status" => true
              ],
              [
                "name" => "Faroe Islands (the)",
                "local" => "Féroé (les Îles)",
                "code" => "FO",
                "status" => true
              ],
              [
                "name" => "Fiji",
                "local" => "Fidji (les)",
                "code" => "FJ",
                "status" => true
              ],
              [
                "name" => "Finland",
                "local" => "Finlande (la)",
                "code" => "FI",
                "status" => true
              ],
              [
                "name" => "France",
                "local" => "France (la)",
                "code" => "FR",
                "status" => true
              ],
              [
                "name" => "French Guiana",
                "local" => "Guyane française (la )",
                "code" => "GF",
                "status" => true
              ],
              [
                "name" => "French Polynesia",
                "local" => "Polynésie française (la)",
                "code" => "PF",
                "status" => true
              ],
              [
                "name" => "French Southern Territories (the)",
                "local" => "Terres australes françaises (les)",
                "code" => "TF",
                "status" => true
              ],
              [
                "name" => "Gabon",
                "local" => "Gabon (le)",
                "code" => "GA",
                "status" => true
              ],
              [
                "name" => "Gambia (the)",
                "local" => "Gambie (la)",
                "code" => "GM",
                "status" => true
              ],
              [
                "name" => "Georgia",
                "local" => "Géorgie (la)",
                "code" => "GE",
                "status" => true
              ],
              [
                "name" => "Germany",
                "local" => "Allemagne (l')",
                "code" => "DE",
                "status" => true
              ],
              [
                "name" => "Ghana",
                "local" => "Ghana (le)",
                "code" => "GH",
                "status" => true
              ],
              [
                "name" => "Gibraltar",
                "local" => "Gibraltar",
                "code" => "GI",
                "status" => true
              ],
              [
                "name" => "Greece",
                "local" => "Grèce (la)",
                "code" => "GR",
                "status" => true
              ],
              [
                "name" => "Greenland",
                "local" => "Groenland (le)",
                "code" => "GL",
                "status" => true
              ],
              [
                "name" => "Grenada",
                "local" => "Grenade (la)",
                "code" => "GD",
                "status" => true
              ],
              [
                "name" => "Guadeloupe",
                "local" => "Guadeloupe (la)",
                "code" => "GP",
                "status" => true
              ],
              [
                "name" => "Guam",
                "local" => "Guam",
                "code" => "GU",
                "status" => true
              ],
              [
                "name" => "Guatemala",
                "local" => "Guatemala (le)",
                "code" => "GT",
                "status" => true
              ],
              [
                "name" => "Guernsey",
                "local" => "Guernesey",
                "code" => "GG",
                "status" => true
              ],
              [
                "name" => "Guinea",
                "local" => "Guinée (la)",
                "code" => "GN",
                "status" => true
              ],
              [
                "name" => "Guinea-Bissau",
                "local" => "Guinée-Bissau (la)",
                "code" => "GW",
                "status" => true
              ],
              [
                "name" => "Guyana",
                "local" => "Guyana (le)",
                "code" => "GY",
                "status" => true
              ],
              [
                "name" => "Haiti",
                "local" => "Haïti",
                "code" => "HT",
                "status" => true
              ],
              [
                "name" => "Heard Island and McDonald Islands",
                "local" => "Heard-et-Îles MacDonald (l'Île)",
                "code" => "HM",
                "status" => true
              ],
              [
                "name" => "Holy See (the)",
                "local" => "Saint-Siège (le)",
                "code" => "VA",
                "status" => true
              ],
              [
                "name" => "Honduras",
                "local" => "Honduras (le)",
                "code" => "HN",
                "status" => true
              ],
              [
                "name" => "Hong Kong",
                "local" => "Hong Kong",
                "code" => "HK",
                "status" => true
              ],
              [
                "name" => "Hungary",
                "local" => "Hongrie (la)",
                "code" => "HU",
                "status" => true
              ],
              [
                "name" => "Iceland",
                "local" => "Islande (l')",
                "code" => "IS",
                "status" => true
              ],
              [
                "name" => "India",
                "local" => "Inde (l')",
                "code" => "IN",
                "status" => true
              ],
              [
                "name" => "Indonesia",
                "local" => "Indonésie (l')",
                "code" => "ID",
                "status" => true
              ],
              [
                "name" => "Iran (Islamic Republic of)",
                "local" => "Iran (République Islamique d')",
                "code" => "IR",
                "status" => true
              ],
              [
                "name" => "Iraq",
                "local" => "Iraq (l')",
                "code" => "IQ",
                "status" => true
              ],
              [
                "name" => "Ireland",
                "local" => "Irlande (l')",
                "code" => "IE",
                "status" => true
              ],
              [
                "name" => "Isle of Man",
                "local" => "Île de Man",
                "code" => "IM",
                "status" => true
              ],
              [
                "name" => "Israel",
                "local" => "Israël",
                "code" => "IL",
                "status" => true
              ],
              [
                "name" => "Italy",
                "local" => "Italie (l')",
                "code" => "IT",
                "status" => true
              ],
              [
                "name" => "Jamaica",
                "local" => "Jamaïque (la)",
                "code" => "JM",
                "status" => true
              ],
              [
                "name" => "Japan",
                "local" => "Japon (le)",
                "code" => "JP",
                "status" => true
              ],
              [
                "name" => "Jersey",
                "local" => "Jersey",
                "code" => "JE",
                "status" => true
              ],
              [
                "name" => "Jordan",
                "local" => "Jordanie (la)",
                "code" => "JO",
                "status" => true
              ],
              [
                "name" => "Kazakhstan",
                "local" => "Kazakhstan (le)",
                "code" => "KZ",
                "status" => true
              ],
              [
                "name" => "Kenya",
                "local" => "Kenya (le)",
                "code" => "KE",
                "status" => true
              ],
              [
                "name" => "Kiribati",
                "local" => "Kiribati",
                "code" => "KI",
                "status" => true
              ],
              [
                "name" => "Korea (the Democratic People's Republic of)",
                "local" => "Corée (la République populaire démocratique de)",
                "code" => "KP",
                "status" => true
              ],
              [
                "name" => "Korea (the Republic of)",
                "local" => "Corée (la République de)",
                "code" => "KR",
                "status" => true
              ],
              [
                "name" => "Kuwait",
                "local" => "Koweït (le)",
                "code" => "KW",
                "status" => true
              ],
              [
                "name" => "Kyrgyzstan",
                "local" => "Kirghizistan (le)",
                "code" => "KG",
                "status" => true
              ],
              [
                "name" => "Lao People's Democratic Republic (the)",
                "local" => "Lao, République démocratique populaire",
                "code" => "LA",
                "status" => true
              ],
              [
                "name" => "Latvia",
                "local" => "Lettonie (la)",
                "code" => "LV",
                "status" => true
              ],
              [
                "name" => "Lebanon",
                "local" => "Liban (le)",
                "code" => "LB",
                "status" => true
              ],
              [
                "name" => "Lesotho",
                "local" => "Lesotho (le)",
                "code" => "LS",
                "status" => true
              ],
              [
                "name" => "Liberia",
                "local" => "Libéria (le)",
                "code" => "LR",
                "status" => true
              ],
              [
                "name" => "Libya",
                "local" => "Libye (la)",
                "code" => "LY",
                "status" => true
              ],
              [
                "name" => "Liechtenstein",
                "local" => "Liechtenstein (le)",
                "code" => "LI",
                "status" => true
              ],
              [
                "name" => "Lithuania",
                "local" => "Lituanie (la)",
                "code" => "LT",
                "status" => true
              ],
              [
                "name" => "Luxembourg",
                "local" => "Luxembourg (le)",
                "code" => "LU",
                "status" => true
              ],
              [
                "name" => "Macao",
                "local" => "Macao",
                "code" => "MO",
                "status" => true
              ],
              [
                "name" => "North Macedonia",
                "local" => "Macédoine du Nord",
                "code" => "MK",
                "status" => true
              ],
              [
                "name" => "Madagascar",
                "local" => "Madagascar",
                "code" => "MG",
                "status" => true
              ],
              [
                "name" => "Malawi",
                "local" => "Malawi (le)",
                "code" => "MW",
                "status" => true
              ],
              [
                "name" => "Malaysia",
                "local" => "Malaisie (la)",
                "code" => "MY",
                "status" => true
              ],
              [
                "name" => "Maldives",
                "local" => "Maldives (les)",
                "code" => "MV",
                "status" => true
              ],
              [
                "name" => "Mali",
                "local" => "Mali (le)",
                "code" => "ML",
                "status" => true
              ],
              [
                "name" => "Malta",
                "local" => "Malte",
                "code" => "MT",
                "status" => true
              ],
              [
                "name" => "Marshall Islands (the)",
                "local" => "Marshall (Îles)",
                "code" => "MH",
                "status" => true
              ],
              [
                "name" => "Martinique",
                "local" => "Martinique (la)",
                "code" => "MQ",
                "status" => true
              ],
              [
                "name" => "Mauritania",
                "local" => "Mauritanie (la)",
                "code" => "MR",
                "status" => true
              ],
              [
                "name" => "Mauritius",
                "local" => "Maurice",
                "code" => "MU",
                "status" => true
              ],
              [
                "name" => "Mayotte",
                "local" => "Mayotte",
                "code" => "YT",
                "status" => true
              ],
              [
                "name" => "Mexico",
                "local" => "Mexique (le)",
                "code" => "MX",
                "status" => true
              ],
              [
                "name" => "Micronesia (Federated States of)",
                "local" => "Micronésie (États fédérés de)",
                "code" => "FM",
                "status" => true
              ],
              [
                "name" => "Moldova (the Republic of)",
                "local" => "Moldova , République de",
                "code" => "MD",
                "status" => true
              ],
              [
                "name" => "Monaco",
                "local" => "Monaco",
                "code" => "MC",
                "status" => true
              ],
              [
                "name" => "Mongolia",
                "local" => "Mongolie (la)",
                "code" => "MN",
                "status" => true
              ],
              [
                "name" => "Montenegro",
                "local" => "Monténégro (le)",
                "code" => "ME",
                "status" => true
              ],
              [
                "name" => "Montserrat",
                "local" => "Montserrat",
                "code" => "MS",
                "status" => true
              ],
              [
                "name" => "Morocco",
                "local" => "Maroc (le)",
                "code" => "MA",
                "status" => true
              ],
              [
                "name" => "Mozambique",
                "local" => "Mozambique (le)",
                "code" => "MZ",
                "status" => true
              ],
              [
                "name" => "Myanmar",
                "local" => "Myanmar (le)",
                "code" => "MM",
                "status" => true
              ],
              [
                "name" => "Namibia",
                "local" => "Namibie (la)",
                "code" => "NA",
                "status" => true
              ],
              [
                "name" => "Nauru",
                "local" => "Nauru",
                "code" => "NR",
                "status" => true
              ],
              [
                "name" => "Nepal",
                "local" => "Népal (le)",
                "code" => "NP",
                "status" => true
              ],
              [
                "name" => "Netherlands (the)",
                "local" => "Pays-Bas (les)",
                "code" => "NL",
                "status" => true
              ],
              [
                "name" => "New Caledonia",
                "local" => "Nouvelle-Calédonie (la)",
                "code" => "NC",
                "status" => true
              ],
              [
                "name" => "New Zealand",
                "local" => "Nouvelle-Zélande (la)",
                "code" => "NZ",
                "status" => true
              ],
              [
                "name" => "Nicaragua",
                "local" => "Nicaragua (le)",
                "code" => "NI",
                "status" => true
              ],
              [
                "name" => "Niger (the)",
                "local" => "Niger (le)",
                "code" => "NE",
                "status" => true
              ],
              [
                "name" => "Nigeria",
                "local" => "Nigéria (le)",
                "code" => "NG",
                "status" => true
              ],
              [
                "name" => "Niue",
                "local" => "Niue",
                "code" => "NU",
                "status" => true
              ],
              [
                "name" => "Norfolk Island",
                "local" => "Norfolk (l'Île)",
                "code" => "NF",
                "status" => true
              ],
              [
                "name" => "Northern Mariana Islands (the)",
                "local" => "Mariannes du Nord (les Îles)",
                "code" => "MP",
                "status" => true
              ],
              [
                "name" => "Norway",
                "local" => "Norvège (la)",
                "code" => "NO",
                "status" => true
              ],
              [
                "name" => "Oman",
                "local" => "Oman",
                "code" => "OM",
                "status" => true
              ],
              [
                "name" => "Pakistan",
                "local" => "Pakistan (le)",
                "code" => "PK",
                "status" => true
              ],
              [
                "name" => "Palau",
                "local" => "Palaos (les)",
                "code" => "PW",
                "status" => true
              ],
              [
                "name" => "Palestine, State of",
                "local" => "Palestine, État de",
                "code" => "PS",
                "status" => true
              ],
              [
                "name" => "Panama",
                "local" => "Panama (le)",
                "code" => "PA",
                "status" => true
              ],
              [
                "name" => "Papua New Guinea",
                "local" => "Papouasie-Nouvelle-Guinée (la)",
                "code" => "PG",
                "status" => true
              ],
              [
                "name" => "Paraguay",
                "local" => "Paraguay (le)",
                "code" => "PY",
                "status" => true
              ],
              [
                "name" => "Peru",
                "local" => "Pérou (le)",
                "code" => "PE",
                "status" => true
              ],
              [
                "name" => "Philippines (the)",
                "local" => "Philippines (les)",
                "code" => "PH",
                "status" => true
              ],
              [
                "name" => "Pitcairn",
                "local" => "Pitcairn",
                "code" => "PN",
                "status" => true
              ],
              [
                "name" => "Poland",
                "local" => "Pologne (la)",
                "code" => "PL",
                "status" => true
              ],
              [
                "name" => "Portugal",
                "local" => "Portugal (le)",
                "code" => "PT",
                "status" => true
              ],
              [
                "name" => "Puerto Rico",
                "local" => "Porto Rico",
                "code" => "PR",
                "status" => true
              ],
              [
                "name" => "Qatar",
                "local" => "Qatar (le)",
                "code" => "QA",
                "status" => true
              ],
              [
                "name" => "Réunion",
                "local" => "Réunion (La)",
                "code" => "RE",
                "status" => true
              ],
              [
                "name" => "Romania",
                "local" => "Roumanie (la)",
                "code" => "RO",
                "status" => true
              ],
              [
                "name" => "Russian Federation (the)",
                "local" => "Russie (la Fédération de)",
                "code" => "RU",
                "status" => true
              ],
              [
                "name" => "Rwanda",
                "local" => "Rwanda (le)",
                "code" => "RW",
                "status" => true
              ],
              [
                "name" => "Saint Barthélemy",
                "local" => "Saint-Barthélemy",
                "code" => "BL",
                "status" => true
              ],
              [
                "name" => "Saint Helena, Ascension and Tristan da Cunha",
                "local" => "Sainte-Hélène, Ascension et Tristan da Cunha",
                "code" => "SH",
                "status" => true
              ],
              [
                "name" => "Saint Kitts and Nevis",
                "local" => "Saint-Kitts-et-Nevis",
                "code" => "KN",
                "status" => true
              ],
              [
                "name" => "Saint Lucia",
                "local" => "Sainte-Lucie",
                "code" => "LC",
                "status" => true
              ],
              [
                "name" => "Saint Martin (French part)",
                "local" => "Saint-Martin (partie française)",
                "code" => "MF",
                "status" => true
              ],
              [
                "name" => "Saint Pierre and Miquelon",
                "local" => "Saint-Pierre-et-Miquelon",
                "code" => "PM",
                "status" => true
              ],
              [
                "name" => "Saint Vincent and the Grenadines",
                "local" => "Saint-Vincent-et-les Grenadines",
                "code" => "VC",
                "status" => true
              ],
              [
                "name" => "Samoa",
                "local" => "Samoa (le)",
                "code" => "WS",
                "status" => true
              ],
              [
                "name" => "San Marino",
                "local" => "Saint-Marin",
                "code" => "SM",
                "status" => true
              ],
              [
                "name" => "Sao Tome and Principe",
                "local" => "Sao Tomé-et-Principe",
                "code" => "ST",
                "status" => true
              ],
              [
                "name" => "Saudi Arabia",
                "local" => "Arabie saoudite (l')",
                "code" => "SA",
                "status" => true
              ],
              [
                "name" => "Senegal",
                "local" => "Sénégal (le)",
                "code" => "SN",
                "status" => true
              ],
              [
                "name" => "Serbia",
                "local" => "Serbie (la)",
                "code" => "RS",
                "status" => true
              ],
              [
                "name" => "Seychelles",
                "local" => "Seychelles (les)",
                "code" => "SC",
                "status" => true
              ],
              [
                "name" => "Sierra Leone",
                "local" => "Sierra Leone (la)",
                "code" => "SL",
                "status" => true
              ],
              [
                "name" => "Singapore",
                "local" => "Singapour",
                "code" => "SG",
                "status" => true
              ],
              [
                "name" => "Sint Maarten (Dutch part)",
                "local" => "Saint-Martin (partie néerlandaise)",
                "code" => "SX",
                "status" => true
              ],
              [
                "name" => "Slovakia",
                "local" => "Slovaquie (la)",
                "code" => "SK",
                "status" => true
              ],
              [
                "name" => "Slovenia",
                "local" => "Slovénie (la)",
                "code" => "SI",
                "status" => true
              ],
              [
                "name" => "Solomon Islands",
                "local" => "Salomon (Îles)",
                "code" => "SB",
                "status" => true
              ],
              [
                "name" => "Somalia",
                "local" => "Somalie (la)",
                "code" => "SO",
                "status" => true
              ],
              [
                "name" => "South Africa",
                "local" => "Afrique du Sud (l')",
                "code" => "ZA",
                "status" => true
              ],
              [
                "name" => "South Georgia and the South Sandwich Islands",
                "local" => "Géorgie du Sud-et-les Îles Sandwich du Sud (la)",
                "code" => "GS",
                "status" => true
              ],
              [
                "name" => "South Sudan",
                "local" => "Soudan du Sud (le)",
                "code" => "SS",
                "status" => true
              ],
              [
                "name" => "Spain",
                "local" => "Espagne (l')",
                "code" => "ES",
                "status" => true
              ],
              [
                "name" => "Sri Lanka",
                "local" => "Sri Lanka",
                "code" => "LK",
                "status" => true
              ],
              [
                "name" => "Sudan (the)",
                "local" => "Soudan (le)",
                "code" => "SD",
                "status" => true
              ],
              [
                "name" => "Suriname",
                "local" => "Suriname (le)",
                "code" => "SR",
                "status" => true
              ],
              [
                "name" => "Svalbard and Jan Mayen",
                "local" => "Svalbard et l'Île Jan Mayen (le)",
                "code" => "SJ",
                "status" => true
              ],
              [
                "name" => "Eswatini",
                "local" => "Eswatini",
                "code" => "SZ",
                "status" => true
              ],
              [
                "name" => "Sweden",
                "local" => "Suède (la)",
                "code" => "SE",
                "status" => true
              ],
              [
                "name" => "Switzerland",
                "local" => "Suisse (la)",
                "code" => "CH",
                "status" => true
              ],
              [
                "name" => "Syrian Arab Republic",
                "local" => "République arabe syrienne (la)",
                "code" => "SY",
                "status" => true
              ],
              [
                "name" => "Taiwan (Province of China)",
                "local" => "Taïwan (Province de Chine)",
                "code" => "TW",
                "status" => true
              ],
              [
                "name" => "Tajikistan",
                "local" => "Tadjikistan (le)",
                "code" => "TJ",
                "status" => true
              ],
              [
                "name" => "Tanzania, United Republic of",
                "local" => "Tanzanie, République-Unie de",
                "code" => "TZ",
                "status" => true
              ],
              [
                "name" => "Thailand",
                "local" => "Thaïlande (la)",
                "code" => "TH",
                "status" => true
              ],
              [
                "name" => "Timor-Leste",
                "local" => "Timor-Leste (le)",
                "code" => "TL",
                "status" => true
              ],
              [
                "name" => "Togo",
                "local" => "Togo (le)",
                "code" => "TG",
                "status" => true
              ],
              [
                "name" => "Tokelau",
                "local" => "Tokelau (les)",
                "code" => "TK",
                "status" => true
              ],
              [
                "name" => "Tonga",
                "local" => "Tonga (les)",
                "code" => "TO",
                "status" => true
              ],
              [
                "name" => "Trinidad and Tobago",
                "local" => "Trinité-et-Tobago (la)",
                "code" => "TT",
                "status" => true
              ],
              [
                "name" => "Tunisia",
                "local" => "Tunisie (la)",
                "code" => "TN",
                "status" => true
              ],
              [
                "name" => "Turkey",
                "local" => "Turquie (la)",
                "code" => "TR",
                "status" => true
              ],
              [
                "name" => "Turkmenistan",
                "local" => "Turkménistan (le)",
                "code" => "TM",
                "status" => true
              ],
              [
                "name" => "Turks and Caicos Islands (the)",
                "local" => "Turks-et-Caïcos (les Îles)",
                "code" => "TC",
                "status" => true
              ],
              [
                "name" => "Tuvalu",
                "local" => "Tuvalu (les)",
                "code" => "TV",
                "status" => true
              ],
              [
                "name" => "Uganda",
                "local" => "Ouganda (l')",
                "code" => "UG",
                "status" => true
              ],
              [
                "name" => "Ukraine",
                "local" => "Ukraine (l')",
                "code" => "UA",
                "status" => true
              ],
              [
                "name" => "United Arab Emirates (the)",
                "local" => "Émirats arabes unis (les)",
                "code" => "AE",
                "status" => true
              ],
              [
                "name" => "United Kingdom of Great Britain and Northern Ireland (the)",
                "local" => "Royaume-Uni de Grande-Bretagne et d'Irlande du Nord (le)",
                "code" => "GB",
                "status" => true
              ],
              [
                "name" => "United States Minor Outlying Islands (the)",
                "local" => "Îles mineures éloignées des États-Unis (les)",
                "code" => "UM",
                "status" => true
              ],
              [
                "name" => "US",
                "local" => "États-Unis d'Amérique (les)",
                "code" => "US",
                "status" => true
              ],
              [
                "name" => "Uruguay",
                "local" => "Uruguay (l')",
                "code" => "UY",
                "status" => true
              ],
              [
                "name" => "Uzbekistan",
                "local" => "Ouzbékistan (l')",
                "code" => "UZ",
                "status" => true
              ],
              [
                "name" => "Vanuatu",
                "local" => "Vanuatu (le)",
                "code" => "VU",
                "status" => true
              ],
              [
                "name" => "Venezuela (Bolivarian Republic of)",
                "local" => "Venezuela (République bolivarienne du)",
                "code" => "VE",
                "status" => true
              ],
              [
                "name" => "Viet Nam",
                "local" => "Viet Nam (le)",
                "code" => "VN",
                "status" => true
              ],
              [
                "name" => "Virgin Islands (British)",
                "local" => "Vierges britanniques (les Îles)",
                "code" => "VG",
                "status" => true
              ],
              [
                "name" => "Virgin Islands (U.S.)",
                "local" => "Vierges des États-Unis (les Îles)",
                "code" => "VI",
                "status" => true
              ],
              [
                "name" => "Wallis and Futuna",
                "local" => "Wallis-et-Futuna ",
                "code" => "WF",
                "status" => true
              ],
              [
                "name" => "Western Sahara*",
                "local" => "Sahara occidental (le)*",
                "code" => "EH",
                "status" => true
              ],
              [
                "name" => "Yemen",
                "local" => "Yémen (le)",
                "code" => "YE",
                "status" => true
              ],
              [
                "name" => "Zambia",
                "local" => "Zambie (la)",
                "code" => "ZM",
                "status" => true
              ],
              [
                "name" => "Zimbabwe",
                "local" => "Zimbabwe (le)",
                "code" => "ZW",
                "status" => true
              ]
            ]
        );
    }
}
