<?php
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

<<<<<<< HEAD
$plugin->version  = 2014030605;   // The (date) version of this module + 2 extra digital for daily versions
=======
$plugin->version  = 2015020401;   // The (date) version of this module + 2 extra digital for daily versions
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
                                  // This version number is displayed into /admin/forms.php
                                  // TODO: if ever this plugin get branched, the old branch number
                                  // will not be updated to the current date but just incremented. We will
                                  // need then a $plugin->release human friendly date. For the moment, we use
                                  // display this version number with userdate (dev friendly)
$plugin->requires = 2010112400;  // Requires this Moodle version - at least 2.0
$plugin->cron     = 0;
<<<<<<< HEAD
$plugin->release = '1.0 (Build: 2014030605)';
=======
$plugin->release = '1.2 (Build: 2015020401)';
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
$plugin->maturity = MATURITY_STABLE;