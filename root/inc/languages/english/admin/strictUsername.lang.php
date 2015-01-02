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

$l['strictUsernameName'] = 'Strict Username';
$l['strictUsernameDesc'] = 'This plugin allows admin to specify allowed characters in the username during the registration.';

$l['strictUsernameGroupDesc'] = 'Settings for plugin "Strict Username"';

$l['strictUsernameMode'] = 'Working mode';
$l['strictUsernameModeDesc'] = "Depending on this setting, the plugin may reject / allow use of under certain chars.";
$l['strictUsernameOptionReject'] = 'Reject';
$l['strictUsernameOptionAllow'] = 'Allow';

$l['strictUsernameStatusCharsSmall'] = 'Lowercase';
$l['strictUsernameStatusCharsSmallDesc'] = "Allow/reject: q, w, e, r, t, y, u, i, o, p, a, s, d, f, g, h, j, k, l, z, x, c, v, b, n, m";

$l['strictUsernameStatusCharsBig'] = 'Uppercase';
$l['strictUsernameStatusCharsBigDesc'] = "Allow/reject: Q, W, E, R, T, Y, U, I, O, P, A, S, D, F, G, H, J, K, L, Z, X, C, V, B, N, M";

$l['strictUsernameStatusNumeric'] = 'Numbers';
$l['strictUsernameStatusNumericDesc'] = "Allow/reject: 0, 1, 2, 3, 4, 5, 6, 7, 8, 9";

$l['strictUsernameStatusSpaces'] = 'Spaces';
$l['strictUsernameStatusSpacesDesc'] = 'It causes that spaces will be allowed/rejected.';

$l['strictUsernameStatusPunctuation'] = 'Punctuation';
$l['strictUsernameStatusPunctuationDesc'] = "Allow/reject: ., ,, :, ;, !, ?, -, _, [, ], (, ), {, }";

$l['strictUsernameStatusSpecials'] = 'Special chars';
$l['strictUsernameStatusSpecialsDesc'] = "Allow/reject: @, |, #, $, %, ^, *, +, =, /, \\";

$l['strictUsernameStatusAdditional'] = 'Additional chars';
$l['strictUsernameStatusAdditionalDesc'] = 'Extra characters to allow/reject, for example national characters. They must be separated by a comma.';

$l['strictUsernameAdditionalChars'] = '_';
