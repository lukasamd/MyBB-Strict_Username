<?php
/**
 * This file is part of Strict Username plugin for MyBB.
 * Copyright (C) Lukasz Tkacz <lukasamd@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */ 

$l['strictUsernameName'] = 'Zabroniony login';
$l['strictUsernameDesc'] = 'Ten plugin pozwala administratorowi ustalić niedozwolone znaki w nazwie użytkownika podawanej podczas rejestracji.';   

$l['strictUsernameGroupDesc'] = 'Ustawienia dotyczące modyfikacji "Zabroniony login"';

$l['strictUsernameMode'] = 'Tryb pracy';
$l['strictUsernameModeDesc'] = "W zależności od tego ustawienia, plugin może zabraniać / zezwalać na używanie poniżej wybranych znaków.";
$l['strictUsernameOptionReject'] = 'Zabraniaj';
$l['strictUsernameOptionAllow'] = 'Zezwalaj';

$l['strictUsernameStatusCharsSmall'] = 'Małe litery';
$l['strictUsernameStatusCharsSmallDesc'] = "Wyklucza/zezwala: q, w, e, r, t, y, u, i, o, p, a, s, d, f, g, h, j, k, l, z, x, c, v, b, n, m";

$l['strictUsernameStatusCharsBig'] = 'Duże litery';
$l['strictUsernameStatusCharsBigDesc'] = "Wyklucza/zezwala: Q, W, E, R, T, Y, U, I, O, P, A, S, D, F, G, H, J, K, L, Z, X, C, V, B, N, M";

$l['strictUsernameStatusNumeric'] = 'Cyfry';
$l['strictUsernameStatusNumericDesc'] = "Wyklucza/zezwala: 0, 1, 2, 3, 4, 5, 6, 7, 8, 9";

$l['strictUsernameStatusSpaces'] = 'Spacje';
$l['strictUsernameStatusSpacesDesc'] = 'Powoduje, że spacje będą niedozwolone/dozwolone.';

$l['strictUsernameStatusPunctuation'] = 'Znaki interpunkcyjne';
$l['strictUsernameStatusPunctuationDesc'] = "Wyklucza/zezwala: ., ,, :, ;, !, ?, -, _, [, ], (, ), {, }";

$l['strictUsernameStatusSpecials'] = 'Znaki specjalne';
$l['strictUsernameStatusSpecialsDesc'] = "Wyklucza/zezwala: @, |, #, $, %, ^, *, +, =, /, \\";

$l['strictUsernameStatusAdditional'] = 'Dodatkowe znaki';
$l['strictUsernameStatusAdditionalDesc'] = 'Dodatkowe znaki do wykluczenia/zezwolenia, np. znaki narodowe. Muszą być one oddzielone przecinkiem.';

$l['strictUsernameAdditionalChars'] = 'Ę,Ó,Ą,Ś,Ł,Ż,Ź,Ć,Ń,ę,ó,ą,ś,ł,ż,ź,ć,ń';
