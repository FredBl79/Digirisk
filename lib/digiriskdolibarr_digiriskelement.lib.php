<?php
/* Copyright (C) 2021 EOXIA <dev@eoxia.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    lib/digiriskdolibarr_digiriskelement.lib.php
 * \ingroup digiriskdolibarr
 * \brief   Library files with common functions for DigiriskElement
 */

/**
 * Prepare array of tabs for DigiriskElement
 *
 * @param	DigiriskElement $object DigiriskElement
 * @return 	array					Array of tabs
 */
function digiriskelementPrepareHead($object)
{
	global $db, $langs, $conf;

	$langs->load("digiriskdolibarr@digiriskdolibarr");

	$h = 0;
	$head = array();
	if ($object->id > 0) {
		$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_risk.php", 1) . '?id=' . $object->id;
		$head[$h][1] = $langs->trans("Risks");
		$head[$h][2] = 'elementRisk';
		$h++;

		$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_evaluator.php", 1) . '?id=' . $object->id;
		$head[$h][1] = $langs->trans("RiskEvaluator");
		$head[$h][2] = 'elementRiskEvaluator';
		$h++;

		$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_risksign.php", 1) . '?id=' . $object->id;
		$head[$h][1] = $langs->trans("RiskSign");
		$head[$h][2] = 'elementRiskSign';
		$h++;

		$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_card.php", 1) . '?id=' . $object->id;
		$head[$h][1] = $langs->trans("Card") . ' ' . $object->ref;
		$head[$h][2] = 'elementCard';
		$h++;

		if ($object->element_type == 'groupment') {
			$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_listingrisksaction.php", 1) . '?id=' . $object->id;
			$head[$h][1] = $langs->trans("ListingRisksAction");
			$head[$h][2] = 'elementListingRisksAction';
			$h++;

			$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_listingrisksphoto.php", 1) . '?id=' . $object->id;
			$head[$h][1] = $langs->trans("ListingRisksPhoto");
			$head[$h][2] = 'elementListingRisksPhoto';
			$h++;
		}

		require_once DOL_DOCUMENT_ROOT . '/core/lib/files.lib.php';
		require_once DOL_DOCUMENT_ROOT . '/core/class/link.class.php';
		$upload_dir = $conf->digiriskdolibarr->dir_output . "/digiriskelement/" . dol_sanitizeFileName($object->ref);
		$nbFiles = count(dol_dir_list($upload_dir, 'files', 0, '', '(\.meta|_preview.*\.png)$'));
		$nbLinks = Link::count($db, $object->element, $object->id);
		$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_document.php", 1) . '?id=' . $object->id;
		$head[$h][1] = $langs->trans('Documents');
		if (($nbFiles + $nbLinks) > 0) $head[$h][1] .= '<span class="badge marginleftonlyshort">' . ($nbFiles + $nbLinks) . '</span>';
		$head[$h][2] = 'elementDocument';
		$h++;

		$head[$h][0] = dol_buildpath("/digiriskdolibarr/digiriskelement_agenda.php", 1) . '?id=' . $object->id;
		$head[$h][1] = $langs->trans("Events");
		$head[$h][2] = 'elementAgenda';
		$h++;

		complete_head_from_modules($conf, $langs, $object, $head, $h, 'digiriskelement@digiriskdolibarr');
	}
	return $head;
}
