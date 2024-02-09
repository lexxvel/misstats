<?php
//
namespace App\Http\Controllers\Api\v1;
//
//require '../vendor/autoload.php';
//
use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use JiraRestApi\Issue\IssueService;
//use JiraRestApi\JiraException;
//
//
//
class JiraController extends Controller
{
//    public function getIssueInfo(Request $request) {
//        $issueName = $request->input('issue');
//        try {
//            $issueService = new IssueService();
//
//            $queryParam = [
//                'fields' => [  // default: '*all'
//                    'summary',
//                    'comment',
//                ],
//                'expand' => [
//                    'renderedFields',
//                    'names',
//                    'schema',
//                    'transitions',
//                    'operations',
//                    'editmeta',
//                    'changelog',
//                ]
//            ];
//
//            $issue = $issueService->get($issueName, $queryParam);
//
//            var_dump($issue->fields);
//            return [
//                $issue->fields
//            ];
//        } catch (JiraRestApi\JiraException $e) {
//            print('Error Occured! ' . $e->getMessage());
//        }
//            }
}
